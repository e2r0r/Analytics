#!/usr/bin/env python
#-*- encoding:utf-8 -*-
import MySQLdb
import urllib2
import _mysql_exceptions

def query(sqlparam,database='msdr',row = 0):
    conn = MySQLdb.connect(host='192.168.8.84',db=database,user='root1',passwd='123')
    try:
        cursor = conn.cursor()
    except (AttributeError, MySQLdb.OperationalError,_mysql_exceptions.OperationalError):
        conn.close()
        conn = MySQLdb.connect(host='192.168.8.84',db=database,user='root1',passwd='123')
        cursor = conn.cursor()
    cursor.execute(sqlparam)
    if not row: r = cursor.fetchone()
    else: r = cursor.fetchall()
    cursor.close()
    return r

def login(sqlparam,database='passport',row = 0):
    conn = MySQLdb.connect(host='192.168.8.160',db=database,user='root1',passwd='123')
    try:
        cursor = conn.cursor()
    except (AttributeError, MySQLdb.OperationalError,_mysql_exceptions.OperationalError):
        conn.close()
        conn = MySQLdb.connect(host='192.168.8.160',db=database,user='root1',passwd='123')
        cursor = conn.cursor()
    cursor.execute(sqlparam)
    if not row: r = cursor.fetchone()
    else: r = cursor.fetchall()
    cursor.close()
    return r


def info():
    httphandle = urllib2.urlopen("http://syn.hunantv-analyse.com/info")
    r = httphandle.readlines()
    #print "info is loading"
    return query(r[0])

def trend():
    httphandle = urllib2.urlopen("http://syn.hunantv-analyse.com/trend")
    r = httphandle.readlines()
    #print "trend is loading"
    return query(r[0])

def user():
    selectsql = "select * from daily_info order by id desc limit 1"
    selectr = query(selectsql)
    did,date = selectr[0],selectr[-1]
    fromselect = 'select count(*) from login_log where date_format(logtime,"%Y%m%d") = "'+date+'"'
    user = login(fromselect)
    sql = "update daily_info set login_user =%d where id = %d "%(user[0],did)
    r = query(sql)
    return r

def second():
    selectsql = "select * from daily_info order by id desc limit 0,2"
    selectr = query(selectsql,row=1)
    register = selectr[0][1] - selectr[1][1]
    login_regd = selectr[0][6] - register
    did = selectr[0][0]
    sql_info = "update daily_info set login_regd_user =%d where id = %d "%(login_regd,did)
    r1 = query(sql_info)
    selectsql2 = "select * from daily_trend order by id desc limit 1"
    t = query(selectsql2)
    sql_trend = "update daily_trend set register =%d where id = %d "%(register,t[0])
    r2 = query(sql_trend)
    #print sql_info,sql_trend 
    return r2[0]

if __name__ == "__main__":
    import  logging
    fh = 'logging.out'
    logging.basicConfig(filename=fh,level=logging.INFO)
    logging.info(info())
    logging.info(trend())
    logging.info(user())
    logging.info(second())
    logging.shutdown()
