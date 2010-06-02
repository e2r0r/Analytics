#!/usr/bin/env python
#-*- encoding:utf-8 -*-

import MySQLdb
import _mysql_exceptions
import simplejson

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


def desc(table,database='msdr'):
    r = query("desc %s"%table,database,1)
    return map(lambda x:x[0],r)


def obj(sqlparam,table,database='msdr',row = 0):
    r = query(sqlparam,database,row)
    d = desc(table,database)
    if not row: return dict(zip(d,r))
    else: return map(lambda x:dict(zip(d,x)),r)




def info(date = ''):
    if not date:
        sql = "select * from daily_info order by date desc limit 1"
    else:
        sql = "select * from daily_info where date = '%s' limit 1"%date
    return obj(sql,'daily_info',row=0)

def infos(start,limit,order = 'desc'):
    sql = "select * from daily_info order by date %s limit %d,%d"%(order,start,limit)
    return obj(sql,"daily_info",row = 1 if limit>1 else 0)

def info_date(start_date,end_start):
    sql = "select * from daily_info where date between %s and %s order by date asc"%(start_date,end_start)
    return obj(sql,'daily_info',row = 1)


def rate(date = '',*args):
    if not date:
        sql = "select * from daily_rate order by id desc limit 1"
    else:
        sql = "select * from daily_rate where date = '%s' limit 1"%date
    
    r = obj(sql,'daily_rate',row = 0)
    return map(lambda x:map(lambda y:[y[0].encode('utf8'),y[1]],simplejson.loads(r[x])),args)

def _trend(start_date,end_start):
    sql = "select * from daily_trend where date between %s and %s order by id asc "%(start_date,end_start)
    return query(sql,row=1)

def trend_date(date = ''):
    if not date:
        sql = "select * from daily_trend order by id desc limit 1"
    else:
        sql = "select * from daily_trend where date = '%s' order by id desc limit 1"%date
    return obj(sql,'daily_trend',row = 0)

def trend(start_date,end_start):
    sql = "select * from daily_trend where date between %s and %s order by date asc "%(start_date,end_start)
    return obj(sql,'daily_trend',row = 1)

def trend_average(start_date,end_start):
    sql = "SELECT avg(register)  , avg(video) , avg(image) , avg(blog) , count(*) FROM daily_trend WHERE date between %s and %s order by date asc"%(start_date,end_start)
    return dict(zip(['register','video','image','blog','total'],map(lambda x:int(x),query(sql))))

def trend_max(start_date,end_start):
    sql = "SELECT max(register)  , max(video) , max(image) , max(blog) , count(*) FROM daily_trend WHERE date between %s and %s order by date asc"%(start_date,end_start)
    return dict(zip(['register','video','image','blog','total'],map(lambda x:int(x),query(sql))))

def info_login(end_start,row = 7):
    sql = "SELECT login_user,user,concat(round((login_user/user*100),2),'%s'),date FROM daily_info WHERE %s >= date order by id desc limit 0,%d"%('%',end_start,row)
    return query(sql,row = 1)

