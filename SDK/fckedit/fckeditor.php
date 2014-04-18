<?php
/**
 * Created by JetBrains PhpStorm.
 * User: weijie
 * Date: 12-12-31
 * Time: 下午4:30
 * To change this template use File | Settings | File Templates.
 */?>
<html>
<head>
    <title>fckeditor 测试</title>
    <script type="text/javascript" src="static/js/fckeditor/fckeditor.js"></script>

    <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.3.min.js" type="text/javascript"></script>
    <script src="static/js/uploadify/jquery.uploadify.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="static/js/uploadify/uploadify.css" />
    <style rel="stylesheet" type="text/css">
    .uploadify-button {
    background-color: transparent;
    border: none;
    padding: 0;
    }
    .uploadify:hover .uploadify-button {
    background-color: transparent;
    }
    </style>
</head>
<body>
<div>
    <?php
    if(isset($_POST['submit'])){
        var_dump($_POST);
    }
    ?>
</div>
<form method="POST" action="">
    <!--<span>第一个</span>
    <script type="text/javascript">
        /*window.onload = function(){
            var oFCKeditor = new FCKeditor( 'fckeditor' ) ;
            oFCKeditor.BasePath = "./static/js/fckeditor/";
            oFCKeditor.ReplaceTextarea() ;
        };*/
    </script>
    <textarea class="fckeditor" id="fckeditor" name="fckeditor"></textarea><br />
    <span>第二个</span>-->
    <script type="text/javascript">
        var oFCKeditor1 = new FCKeditor('FCKeditor1');
        oFCKeditor1.BasePath = "./static/js/fckeditor/";
        oFCKeditor1.Create();
    </script>
    <br />
    <br />
    <input id="file_upload" name="file_upload" type="file" multiple="true" />
    <div id="upload_complete">
        <table width="100%" cellspacing="0" id="filelist">
        </table>
    </div>
    <a href="javascript:$('#file_upload').uploadify('upload','*')">上传</a> |
    <a href="javascript:$('#file_upload').uploadify('cancel', '*')">清除队列</a>
    <br /><br />
    <input type="submit" name="submit" value="提交" />
</form>


<script type="text/javascript">
    <?php $timestamp = time();?>
    function UploadComplete(file, data, response)
    {
        alert(file);
        /*var newfilename = response;
        var oldfilename = fileObj.name;
        var size = to2bits(fileObj.size/1024);
        addFiles(queueID,oldfilename,newfilename,size);*/
    }
    //根据是否修改数据库来定义该方法
    function addFiles(queueID,oldfilename,newfilename,size)
    {
//addDBFile(oldfilename,newfilename,size);//添加到数据库
        /*begin 单文件添加*/
        if($("#filelist").text() != "")
        {
            var trid = $("#filelist tr").attr("id");
            var fileName = delpagefile(trid);//删除页面数据
        }
        /*end*/
        addpagefile(queueID,oldfilename,newfilename,size);//添加到页面
    }
    //添加页面显示文件
    function addpagefile(trid,oldfilename,newfilename,filesize)
    {
        if (oldfilename != "")
        {
            var file = "<tr id='" + trid + "'><td class='td1'><a target='_blank' href='../uploads/" + newfilename + "'>" + oldfilename + "</a></td>";
            file += "<td class='td2'><span>" + filesize + " KB</span></td>";
            file += "<td class='td2'><input type='button' onclick='delFiles(\"" + trid + "\")' /></td></tr>";
            var filelist = $("#filelist").html();
            $("#filelist").attr("class",okMsgclass);
            $("#filelist").html(filelist + file);
        }
    }
    $(function() {
        $('#file_upload').uploadify({
            'formData'     : {
                'timestamp' : '<?php echo $timestamp;?>',
                'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
            },
            'auto' : false,
            'fileTypeExts': '*.jpg;*.jpeg;*.png;*.doc;*.xls;*.ppt;*.pdf;*.rar;*.docx;*.zip',
            'multi': false,
            'displayData': 'speed',
            'width': 77,
            'height': 22,
            'buttonImage' : 'static/js/uploadify/addfiles.png',
            'swf'      : 'static/js/uploadify/uploadify.swf',
            'uploader' : 'static/js/uploadify/uploadify.php',
            'onUploadComplete' : function(file) {
            alert('The file ' + file.path+file.name + ' finished processing.');
        }
        /*'itemTemplate' : '<div id="${fileID}" class="uploadify-queue-item">\
                <div class="cancel">\
                    <a href="javascript:$(\'#${instanceID}\').uploadify(\'cancel\', \'${fileID}\')">X</a>\
                </div>\
                <span class="fileName">${fileName} (${fileSize})</span><span class="data"></span>\
            </div>'*/
        });
    });

</script>

</body>
</html>