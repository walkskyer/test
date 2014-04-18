<?php
/**
 * Created by JetBrains PhpStorm.
 * User: weijie
 * Date: 13-3-9
 * Time: 下午2:44
 * File: hello.php
 * To change this template use File | Settings | File Templates.
 */
$locations=array();
if(!empty($_POST)){
    $locations=$_POST['locations'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>百度地图测试</title>
    <style type="text/css">
        html{height:100%}
        body{height:100%;margin:0px;padding:0px}
        #container{height:95%}
    </style>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>
    <script type="text/javascript" src="http://lib.sinaapp.com/js/jquery/1.9.0/jquery.min.js"></script>
</head>

<body>
<div id="form">
    <form action="" method="post">
        <?php
/*        if (!empty($locations)) {
            foreach ($locations as $location) {
                list($lng,$lat)=explode(',',$location);
                */?><!--
                <input id="<?php /*echo str_replace('.','',$lng.'_'.$lat);*/?>"
                       name="locations[]" type="text" value="<?php /*echo $location;*/?>" /><br>
                <?php /*} */?>
            --><?php //} ?>
        <div id="location-info"></div>
        <input id="submit" type="submit" value="提交标注信息" />
    </form>
</div>

<div id="container"></div>
<script type="text/javascript">
    var map = new BMap.Map("container"); // 创建地图实例
    var point = new BMap.Point(117.003, 36.655); // 创建点坐标
    map.centerAndZoom(point, 13); // 初始化地图，设置中心点坐标和地图级别

    map.addControl(new BMap.NavigationControl());
    map.addControl(new BMap.ScaleControl());
    map.addControl(new BMap.OverviewMapControl());
    map.addControl(new BMap.MapTypeControl());

    <?php
    if(!empty($locations)){
        foreach($locations as $location){
            //list($lng,$lat)=explode(',',$location);
            ?>
            var marker = addMarker(new BMap.Point(<?php echo $location?>));        // 创建标注
            map.addOverlay(marker);
            <?php }?>
    <?php } ?>

    /*var traffic = new BMap.TrafficLayer();        // 创建交通流量图层实例
    map.addTileLayer(traffic);                   // 将图层添加到地图上*/

    map.enableScrollWheelZoom();    //启用滚轮放大缩小，默认禁用
    map.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用

    var contextMenu = new BMap.ContextMenu();
    var txtMenuItem = [
        {
            text:'放大',
            callback:function(){map.zoomIn()}
        },
        {
            text:'缩小',
            callback:function(){map.zoomOut()}
        },
        {
            text:'放置到最大级',
            callback:function(){map.setZoom(18)}
        },
        {
            text:'查看全国',
            callback:function(){map.setZoom(4)}
        },
        {
            text:'在此添加标注',
            callback:function(p){
                var marker=addMarker(p);
                map.addOverlay(marker);
            }
        },
        {
            text:'清除标注',
            callback:function(){map.clearOverlays()}
        }
    ];


    for(var i=0; i < txtMenuItem.length; i++){
        contextMenu.addItem(new BMap.MenuItem(txtMenuItem[i].text,txtMenuItem[i].callback,100));
        if(i==1 || i==3) {
            contextMenu.addSeparator();
        }
    }
    map.addContextMenu(contextMenu);

    function lng_lat(lng,lat){
        var id=lng+"_"+lat;
        id=id.replace('.','');
        id=id.replace('.','');
        return id;
    }

    /**
     * 添加一个marker覆盖物
     * @param p
     * @return {BMap.Marker}
     */
    function addMarker(p){
        var markMenu = new BMap.ContextMenu();
        markMenu.addItem(new BMap.MenuItem('删除此标注',function(){map.removeOverlay(marker)},100));

        var marker = new BMap.Marker(p,{enableDragging: true,
            raiseOnDrag: true
        });
        marker.addContextMenu(markMenu);

        marker.addEventListener('click',function(){//显示信息
            var point=this.getPosition();
            var content='你标注的位置在这里，坐标为('+ point.lng+','+ point.lat+')<br> <a href="http://yiitest.zwj" target="_blank">前往</a>';
            marker.openInfoWindow(new BMap.InfoWindow(content,{offset:new BMap.Size(0,0)}));
        });
        marker.addEventListener('mousedown',function(){//拖拽结束
            var point=this.getPosition();
            //alert('我现在的坐标是：（'+point.lng+'，'+ point.lat+'）');
            $('#'+lng_lat(point.lng,point.lat)).remove();
        });
        marker.addEventListener('remove',function(){//拖拽结束
            var point=this.getPosition();
            //alert('我现在的坐标是：（'+point.lng+'，'+ point.lat+'）');
            $('#'+lng_lat(point.lng,point.lat)).remove();
        });
        marker.addEventListener('mouseup',function(){//拖拽结束
            var point=this.getPosition();
            var content='你标注的位置在这里，坐标为('+ point.lng+','+ point.lat+')<br> <a href="http://yiitest.zwj" target="_blank">前往</a>';
            this.openInfoWindow(new BMap.InfoWindow(content,{offset:new BMap.Size(0,0)}));
            var locationInfo='<input id="'+ lng_lat(point.lng,point.lat)+'"' +
                    'name="locations[]" type="text" value="'+ point.lng+','+ point.lat+'" /><br>';
            $('#location-info').html($('#location-info').html()+locationInfo);
        });

        //将定位信息存入表单
        var locationInfo='<input id="'+lng_lat(p.lng, p.lat)+'"' +
                'name="locations[]" type="text" value="'+ p.lng+','+ p.lat+'" /><br>';
        $('#location-info').html($('#location-info').html()+locationInfo);

        return marker;
    }
</script>
</body>
</html>