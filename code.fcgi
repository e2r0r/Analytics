#!/usr/bin/env python
#-*- encoding:utf-8 -*-

import web
from model import *
import time

urls = ('/','index',
        '/table/info','table_info',
        '/chart/info','chart_info',
        '/table/trend','table_trend',
        '/chart/trend','chart_trend',
        '/table/trend/average','table_trend_average',
        '/table/trend/max','table_trend_max',
        '/table/infos','table_infos',
        '/chart/rate','chart_rate',
        '/table/rate','table_rate',
        '/table/info/login','table_info_login',
        '/chart/info/login','chart_info_login',
        '/chart/info/date','chart_info_date',
        '/rate','bily',
        '/static/','static'
        )

app = web.application(urls,globals())
render = web.template.render('/data/www/analyse/template/',)

class table_info:
    def GET(self):
        qs = web.input(date='')
        dinfo = info(qs.date)
        dtrend = trend_date(qs.date)
        tp_cell = ';'.join(map(lambda x:"data.setCell(0,"+str(x)+",%d,'%s')",range(0,10)))%(dinfo['user'],str(dinfo['user']),dinfo['male_user'],str(dinfo['male_user']),dinfo['female_user'],str(dinfo['female_user']),dinfo['import_user'],str(dinfo['import_user']),dinfo['real_user'],str(dinfo['real_user']),dinfo['login_regd_user'],str(dinfo['login_regd_user']),dtrend['register'],str(dtrend['register']),dtrend['video'],str(dtrend['video']),dtrend['blog'],str(dtrend['blog']),dtrend['image'],str(dtrend['image']))
        html = """<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <script type='text/javascript' src='http://www.google.com/jsapi'></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {packages:['table']});
      google.setOnLoadCallback(drawTable);
      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('number', '注册人数');
        data.addColumn('number', '男性用户');
        data.addColumn('number', '女性用户');
        data.addColumn('number', '导入注册');
        data.addColumn('number', '自主注册');
        data.addColumn('number', '活跃登陆');
        data.addColumn('number', '同比用户新增');
        data.addColumn('number', '同比视频新增');
        data.addColumn('number', '同比日志新增');
        data.addColumn('number', '同比相片新增');
        data.addRows(1);"""+tp_cell+""";
       var table = new google.visualization.Table(document.getElementById('table_div'));
       table.draw(data, {showRowNumber: false});
      }
    </script>
  </head>

  <body>
    <div id='table_div'></div>
  </body>
</html>
"""
        return html


class chart_info:
    def GET(self):
        qs = web.input(start='20100117',end=time.strftime("%Y%m%d", time.localtime()))
        dinfo = info_date(qs.start,qs.end)
        tp_cell = ','.join(map(lambda x:"[new Date("+str(time.strptime(x['date'],'%Y%m%d')[0])+","+str(time.strptime(x['date'],'%Y%m%d')[1]-1)+","+str(time.strptime(x['date'],'%Y%m%d')[2])+"),%d,%d,%d]"%(x['user'],x['import_user'],x['real_user']),dinfo))
        html = """<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <script type='text/javascript' src='http://www.google.com/jsapi'></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {'packages':['annotatedtimeline']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Date');
        data.addColumn('number', '总注册人数');
        data.addColumn('number', '导入注册');
        data.addColumn('number', '自主注册');
        data.addRows(["""+tp_cell+"""]);

        var chart = new google.visualization.AnnotatedTimeLine(document.getElementById('chart_div'));
        chart.draw(data, {displayAnnotations: true});
      }
    </script>
  </head>

  <body>
    <div id='chart_div' style='width: 100%; height: 100%;'></div>
  </body>
</html>"""
        return html

class table_trend:
    def GET(self):
        qs = web.input(start='20091114',end=time.strftime("%Y%m%d", time.localtime()))
        dtrend = trend(qs.start,qs.end)
        tp_c = map(lambda x:"data.setCell("+str(x)+",0,%d);data.setCell("+str(x)+",1,%d);data.setCell("+str(x)+",2,%d);data.setCell("+str(x)+",3,%d);data.setCell("+str(x)+",4,%d)",range(len(dtrend)))
        tp_cell = ';'.join(map(lambda x,y:x%(int(y['date']),int(y['register']),int(y['video']),int(y['image']),int(y['blog'])),tp_c,dtrend))
        html="""<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <script type='text/javascript' src='http://www.google.com/jsapi'></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {packages:['table']});
      google.setOnLoadCallback(drawTable);
      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('number', '日期');
        data.addColumn('number', '新增注册人数');
        data.addColumn('number', '新增视频数');
        data.addColumn('number', '新增相片数');
        data.addColumn('number', '新增博客数');
        data.addRows("""+str(len(dtrend))+""");"""+tp_cell+""";


       var table = new google.visualization.Table(document.getElementById('table_div'));
       table.draw(data, {showRowNumber: true});
      }
    </script>
  </head>

  <body>
    <div id='table_div'></div>
  </body>
</html>
"""
        return html

  
class chart_trend:
    def GET(self):
        qs = web.input(start='20091114',end=time.strftime("%Y%m%d", time.localtime()))
        dtrend = trend(qs.start,qs.end)
        tp_cell = ','.join(map(lambda x:"[new Date("+str(time.strptime(x['date'],'%Y%m%d')[0])+","+str(time.strptime(x['date'],'%Y%m%d')[1]-1)+","+str(time.strptime(x['date'],'%Y%m%d')[2])+"),%d,%d,%d,%d]"%(x['register'],x['video'],x['image'],x['blog']),dtrend))
        html = """<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <script type='text/javascript' src='http://www.google.com/jsapi'></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {'packages':['annotatedtimeline']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('date', '日期');
        data.addColumn('number', '新增注册');
        data.addColumn('number', '新增视频');
        data.addColumn('number', '新增相片');
        data.addColumn('number', '新增日志');
        data.addRows(["""+tp_cell+"""]);

        var chart = new google.visualization.AnnotatedTimeLine(document.getElementById('chart_div'));
        chart.draw(data, {displayAnnotations: true});
      }
    </script>
  </head>

  <body>
    <div id='chart_div' style='width: 100%; height: 100%;'></div>
  </body>
</html>"""
        return html

class table_trend_average:
    def GET(self):
        qs = web.input(start='20091114',end=time.strftime("%Y%m%d", time.localtime()))
        dtrend_average = trend_average(qs.start,qs.end)
        tp_cell = ';'.join(map(lambda x:"data.setCell(0,"+str(x)+",%d,'%s')",range(0,4)))%(dtrend_average['register'],str(dtrend_average['register']),dtrend_average['video'],str(dtrend_average['video']),dtrend_average['image'],str(dtrend_average['image']),dtrend_average['blog'],str(dtrend_average['blog']))
        html = """<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <script type='text/javascript' src='http://www.google.com/jsapi'></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {packages:['table']});
      google.setOnLoadCallback(drawTable);
      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('number', '平均注册人数');
        data.addColumn('number', '平均新增视频');
        data.addColumn('number', '平均新增相片');
        data.addColumn('number', '平均新增日志');
        data.addRows(1);"""+tp_cell+""";
       var table = new google.visualization.Table(document.getElementById('table_div'));
       table.draw(data, {showRowNumber: false});
      }
    </script>
  </head>

  <body>
    <div id='table_div'></div>
  </body>
</html>
"""
        return html

class table_trend_max:
    def GET(self):
        qs = web.input(start='20091114',end=time.strftime("%Y%m%d", time.localtime()))
        dtrend_max = trend_max(qs.start,qs.end)
        tp_cell = ';'.join(map(lambda x:"data.setCell(0,"+str(x)+",%d,'%s')",range(0,4)))%(dtrend_max['register'],str(dtrend_max['register']),dtrend_max['video'],str(dtrend_max['video']),dtrend_max['image'],str(dtrend_max['image']),dtrend_max['blog'],str(dtrend_max['blog']))
        html = """<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <script type='text/javascript' src='http://www.google.com/jsapi'></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {packages:['table']});
      google.setOnLoadCallback(drawTable);
      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('number', '区间新注册人数峰值');
        data.addColumn('number', '区间新增视频峰值');
        data.addColumn('number', '区间新增相片峰值');
        data.addColumn('number', '区间新增日志峰值');
        data.addRows(1);"""+tp_cell+""";
       var table = new google.visualization.Table(document.getElementById('table_div'));
       table.draw(data, {showRowNumber: false});
      }
    </script>
  </head>

  <body>
    <div id='table_div'></div>
  </body>
</html>
"""
        return html
        
class table_infos:
    def GET(self):
        qs = web.input(start='20100117',end=time.strftime("%Y%m%d", time.localtime()))
        dtrend = info_date(qs.start,qs.end)
        tp_c = map(lambda x:"data.setCell("+str(x)+",0,%d);data.setCell("+str(x)+",1,%d);data.setCell("+str(x)+",2,%d);data.setCell("+str(x)+",3,%d);data.setCell("+str(x)+",4,%d);data.setCell("+str(x)+",5,%d);data.setCell("+str(x)+",6,%d);data.setCell("+str(x)+",7,%d);data.setCell("+str(x)+",8,%d);data.setCell("+str(x)+",9,%d)",range(len(dtrend)))
        tp_cell = ';'.join(map(lambda x,y:x%(int(y['date']),int(y['user']),int(y['male_user']),int(y['female_user']),int(y['import_user']),int(y['real_user']),int(y['login_regd_user']),int(y['video']),int(y['image']),int(y['blog'])),tp_c,dtrend))
        html="""<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <script type='text/javascript' src='http://www.google.com/jsapi'></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {packages:['table']});
      google.setOnLoadCallback(drawTable);
      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('number', '日期');
        data.addColumn('number', '总注册人数');
        data.addColumn('number', '男性用户');
        data.addColumn('number', '女性用户');
        data.addColumn('number', '导入注册');
        data.addColumn('number', '自主注册');
        data.addColumn('number', '老用户登陆数');
        data.addColumn('number', '视频总数');
        data.addColumn('number', '相片总数');
        data.addColumn('number', '博客总数');
        data.addRows("""+str(len(dtrend))+""");"""+tp_cell+""";


       var table = new google.visualization.Table(document.getElementById('table_div'));
       table.draw(data, {showRowNumber: true});
      }
    </script>
  </head>

  <body>
    <div id='table_div'></div>
  </body>
</html>
"""
        return html

class chart_rate:
    def GET(self):
        qs = web.input(t='age',date='')
        trate = rate(qs.date,qs.t)[0]
        tp_cell = """data.addColumn('string', 'Task'); 
                  data.addColumn('number', 'persons'); 
                  data.addRows(%d);"""%len(trate)
        tp_cell += ';'.join(map(lambda x,y:"data.setValue(%d, 0, '%s');data.setValue(%d, 1, %d)"%(y,x[0],y,int(x[1])),trate,range(0,len(trate))))
        html = """<html>
  <head> 
<meta http-equiv="Content-Type" content="text/html; charset="UTF-8">
    <script type="text/javascript" src="http://www.google.com/jsapi"></script> 
    <script type="text/javascript"> 
      google.load("visualization", "1", {packages:["piechart"]}); 
      google.setOnLoadCallback(drawChart); 
      
function drawChart() { 
        var data = new google.visualization.DataTable();"""+tp_cell+""";var chart = new google.visualization.PieChart(document.getElementById('chart_div')); 
        chart.draw(data, {width: 400, height: 240, is3D: true,title:''}); 
      }
 </script> 
  </head> 
 
  <body> 
    <div id="chart_div"></div> 
</body> 
</html>"""
        return html

class table_rate:
    def GET(self):
        qs = web.input(t='age',date='')
        trate = rate(qs.date,qs.t)[0]
        table = "data.addRows(%d);"%len(trate)
        table += ';'.join(map(lambda x,y:"data.setCell(%d, 0, '%s');data.setCell(%d, 1, %d,'%d')"%(y,x[0],y,int(x[1]),int(x[1])),trate,range(0,len(trate))))
        html = """<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="http://www.google.com/jsapi"></script> 
    <script type="text/javascript"> 
      google.load("visualization", "1", {packages:["table"]}); 
      google.setOnLoadCallback(drawTable);
      function drawTable() {
   var data = new google.visualization.DataTable();
   data.addColumn('string', '垂直区间');
   data.addColumn('number', '分布人数');"""+table+""";
 var table = new google.visualization.Table(document.getElementById('table_div'));
   table.draw(data, {width: 400,showRowNumber: false});}
     </script> 
   </head> 

   <body> 
     <div id="table_div"></div>  
 </body> 
 </html>"""
        return html


class table_info_login:
    def GET(self):
        qs = web.input(end=time.strftime("%Y%m%d", time.localtime()))
        login = info_login(qs.end)
        tp_c = map(lambda x:"data.setCell("+str(x)+",0,%d);data.setCell("+str(x)+",1,%d);data.setCell("+str(x)+",2,'%s')",range(0,len(login)))
        tp_cell = ';'.join(map(lambda x,y:x%(int(y[3]),int(y[0]),y[2]),tp_c,login))
        html="""<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <script type='text/javascript' src='http://www.google.com/jsapi'></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {packages:['table']});
      google.setOnLoadCallback(drawTable);
      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('number', '统计日期');
        data.addColumn('number', '日活跃用户');
        data.addColumn('string', '占总数比例');
        data.addRows("""+str(len(login))+""");"""+tp_cell+""";


       var table = new google.visualization.Table(document.getElementById('table_div'));
       table.draw(data, {showRowNumber: true});
      }
    </script>
  </head>

  <body>
    <div id='table_div'></div>
  </body>
</html>
"""
        return html

class chart_info_login:
    def GET(self):
        qs = web.input(end=time.strftime("%Y%m%d", time.localtime()))
        login = info_login(qs.end)
        tp_cell = ','.join(map(lambda x:"[new Date("+str(time.strptime(x[3],'%Y%m%d')[0])+","+str(time.strptime(x[3],'%Y%m%d')[1]-1)+","+str(time.strptime(x[3],'%Y%m%d')[2])+"),%d]"%int(x[0]),login))
        html = """<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <script type='text/javascript' src='http://www.google.com/jsapi'></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {'packages':['annotatedtimeline']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Date');
        data.addColumn('number', '活跃用户');
        data.addRows(["""+tp_cell+"""]);

        var chart = new google.visualization.AnnotatedTimeLine(document.getElementById('chart_div'));
        chart.draw(data, {displayAnnotations: true});
      }
    </script>
  </head>

  <body>
    <div id='chart_div' style='width: 100%; height: 100%;'></div>
  </body>
</html>"""
        return html

class chart_info_date:
    def GET(self):
        qs = web.input(start='20100117',end=time.strftime("%Y%m%d", time.localtime()))
        dinfo = info_date(qs.start,qs.end)
        tp_c = map(lambda x:"data.setValue("+str(x)+", 0, '%s');data.setValue("+str(x)+", 1, %d)",range(0,len(dinfo)))
        tp_cell = ';'.join(map(lambda x,y:x%(y['date'],y['user']),tp_c,dinfo))
        html = """<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["areachart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', '日期');
        data.addColumn('number', '总注册人数');
        data.addRows("""+str(len(dinfo))+""");"""+tp_cell+""";
       

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, { height: 240, legend: 'right', title: ''});
      }
    </script>
  </head>

  <body>
    <div id="chart_div"></div>
  </body>
</html>"""
        return html

class index:
    def GET(self):
        return render.index()

class bily:
    def GET(self):
        return render.rate()

def internalerror():
    return web.internalerror("<img src='/static/500.jpg'></img>")
app.internalerror =internalerror

if __name__ =="__main__":
    web.wsgi.runwsgi = lambda func, addr=None: web.wsgi.runfcgi(func,
addr)
    app.run()
