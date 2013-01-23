<?php
/**
 * Created by JetBrains PhpStorm.
 * User: weijie
 * Date: 12-12-31
 * Time: 下午10:23
 * To change this template use File | Settings | File Templates.
 */
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>
        编辑器
    </title>
    <link href="static/css/body.css" type="text/css" rel="stylesheet"/>
    <link href="static/css/css.css" type="text/css" rel="stylesheet"/>

    <script type="text/javascript" src="static/js/fckeditor/fckeditor.js"></script>
    <script language="javascript" type="text/javascript"
            src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.3.min.js"></script>
    <script language="javascript" type="text/javascript" src="static/js/uploadify/jquery.uploadify.min.js"></script>
    <script language="javascript" type="text/javascript" src="static/js/uploadify/UploadHandlers.js"></script>

    <link type="text/css" rel="stylesheet" href="static/js/uploadify/uploadify.css"/>
    <script language="javascript" type="text/javascript">
        //获取上传文件客户端ID
        function getUploadId() {
            var objID = "#fuUpload_fileUpload";
            return objID;
        }
        //获取文件保存路径
        function getFolder() {
            var folder = "/uploads";
            return folder;
        }
        function gethfMainID() {
            var obj = $("#hfMainID")
            return obj;
        }
        function gethfFlag() {
            var obj = $("#hfFlag")
            return obj;
        }
        function getfiles() {
            var newNames = getNewFileNames();
            var oldNames = getOldFileNames();
            var fileSizes = getFileSizes();

            $("#hfNewName").val(newNames);
            $("#hfOldName").val(oldNames);
            $("#hfFileSize").val(fileSizes);
        }
        //根据是否修改数据库来定义该方法
        function addFiles(queueID, oldfilename, newfilename, size) {
            //addDBFile(oldfilename,newfilename,size);//添加到数据库
            addpagefile(queueID, oldfilename, newfilename, size);//添加到页面
        }
        //只需修改该方法，来确认删除几个地方的数据
        function delFiles(trid) {
            var fileName = delpagefile(trid);//删除页面数据
            delRealFile(fileName);//删除服务器数据
//    delDBFile(fileName);//删除数据库数据
        }

        var oEditer;
        function FCKeditor_OnComplete(editorInstance) {
            oEditer = editorInstance;
        }
        function checkForm() {
            getfiles();
            var str = oEditer.GetXHTML(true);
            if (str == "") {
                alert("请填写资料内容");
                return false;
            }
            else {
                var theForm = document.getElementById("form1");
                return Validator.Validate(theForm, 1);
            }
        }
    </script>
</head>
<body>
<form name="form1" method="post" action="com_infoAdd.aspx" id="form1" enctype="multipart/form-data">
<div>
    <input type="hidden" name="__EVENTTARGET" id="__EVENTTARGET" value=""/>
    <input type="hidden" name="__EVENTARGUMENT" id="__EVENTARGUMENT" value=""/>
    <input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE"
           value="/wEPDwUKLTQ0ODI5MTQ1NA9kFgICAQ8WAh4HZW5jdHlwZQUTbXVsdGlwYXJ0L2Zvcm0tZGF0YWRkbSTQYSsr/ogJ4x71weDyacG7A3U="/>
</div>

<script type="text/javascript">
    <!--
    var theForm = document.forms['form1'];
    if (!theForm) {
        theForm = document.form1;
    }
    function __doPostBack(eventTarget, eventArgument) {
        if (!theForm.onsubmit || (theForm.onsubmit() != false)) {
            theForm.__EVENTTARGET.value = eventTarget;
            theForm.__EVENTARGUMENT.value = eventArgument;
            theForm.submit();
        }
    }
    // -->
</script>


<div>
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="Table1">
    <tr>
        <td height="25">
            <span class="bold">您的位置：交流平台管理</span></td>
    </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="Table2">
    <tr>
        <td>
            &nbsp;</td>
    </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="1" style="text-align: left;
                background-color: #8e9be1;">
    <tr>
        <td bgcolor="#cbcfed">
            <table width="100%" border="0" id="Table4">
                <tr>
                    <td width="30">
                        <img src="images/title1.gif" width="16" height="16"></td>
                    <td>
                        <span class="bold">您的位置：新增</span></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="text-align: center; background-color: #ffffff;">
            <br/>
            <table width="98%" border="0" style="background-color: #8e9be1;" cellpadding="3"
                   cellspacing="1" align="center">
                <tr style="background-color: #ebedfa;">
                    <td style="width: 15%;">
                        <font color="#000000">作者：</font></td>
                    <td style="width: 35%; text-align: left; background-color: #ffffff;">
                        <input name="txtAuthor" type="text" value="超级管理员" id="txtAuthor" class="text"
                               dataType="Limit" min="1" max="30" msg="作者应在[1,10]个字之内" style="width:350px;"/>
                    </td>
                </tr>
                <tr style="background-color: #ebedfa;">
                    <td style="width: 15%;">
                        <font color="#000000">标题：</font></td>
                    <td style="width: 35%; text-align: left; background-color: #ffffff;">
                        <input name="txtTitle" type="text" id="txtTitle" class="text" dataType="Limit" min="1"
                               max="30" msg="标题应在[1,30]个字之内" style="width:350px;"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" bgcolor="#ffffff">
                        <div><input type="hidden" id="FCKeditor1" name="FCKeditor1" value=""/><input
                                type="hidden" id="FCKeditor1___Config" value="HtmlEncodeOutput=true"/>
                            <iframe id="FCKeditor1___Frame"
                                    src="static/js/fckeditor/editor/fckeditor.html?InstanceName=FCKeditor1&amp;Toolbar=Default"
                                    width="100%" height="500px" frameborder="no" scrolling="no"></iframe>
                        </div>
                    </td>
                </tr>
                <tr style="background-color: #ebedfa;">
                    <td style="width: 15%;">
                        <font color="#000000">附件上传：</font></td>
                    <td style="width: 35%; text-align: left; background-color: #ffffff;">
                        <input type="hidden" name="hfOldName" id="hfOldName"/>
                        <input type="hidden" name="hfNewName" id="hfNewName"/>
                        <input type="hidden" name="hfFileSize" id="hfFileSize"/>
                        <input type="hidden" name="hfFlag" id="hfFlag" value="1"/>
                        <input type="hidden" name="hfMainID" id="hfMainID" value="0"/>


                        <script language="javascript" type="text/javascript">

                            $(window).load(
                                    function () {
                                        LoadUploadVariables_fuUpload();
                                    }
                            );

                            function LoadUploadVariables_fuUpload() {
                                /*$("#fuUpload_fileUpload").fileUpload({
                                    'uploader': '/sqmy/front/js/uploadify/uploader.swf',
                                    'cancelImg': '/sqmy/front/js/uploadify/cancel.png',
                                    'folder': '/uploads',
                                    'script': '/sqmy/front/js/uploadify/Upload.ashx',
                                    'fileExt': '*.jpg;*.jpeg;*.png;*.doc;*.xls;*.ppt;*.pdf;*.rar;*.docx;*.zip',
                                    'fileDesc': '*.jpg;*.jpeg;*.png;*.doc;*.xls;*.ppt;*.pdf;*.rar;*.docx;*.zip',
                                    'sizeLimit': '10485760',
                                    'multi': true,
                                    'buttonText': 'select files...',
                                    'buttonImg': '/sqmy/front/js/uploadify/addfiles.png',
                                    'displayData': 'speed',
                                    'auto': false,
                                    'width': 77,
                                    'height': 22,

                                    'onSelect': function(event, queueID, fileObj) { },
                                    'onCancel': function(event, queueID, fileObj,data) { },
                                    'onClearQueue': function(event, data) { },
                                    'onComplete': UploadComplete,
                                    'onAllComplete': function(event,data) { },
                                    'onError': UploadError
                                });*/
                            <?php $timestamp = time();?>
                                $(function () {
                                    $('#fuUpload_fileUpload').uploadify({
                                        'formData':{
                                            'timestamp':'<?php echo $timestamp;?>',
                                            'token':'<?php echo md5('unique_salt' . $timestamp);?>'
                                        },
                                        'auto':false,
                                        'fileTypeExts':'*.jpg;*.jpeg;*.png;*.doc;*.xls;*.ppt;*.pdf;*.rar;*.docx;*.zip',
                                        'multi':true,
                                        'displayData':'speed',
                                        'width':77,
                                        'height':22,
                                        'buttonImage':'static/js/uploadify/addfiles.png',
                                        'swf':'static/js/uploadify/uploadify.swf',
                                        'uploader':'static/js/uploadify/uploadify.php',
                                        //'onComplete': UploadComplete
                                        'onUploadSuccess':function (file, data, response) {
                                            /*alert('The file ' + file.name +
                                                    ' was successfully uploaded with a response of ' + response +
                                                    ':' + data);*/
                                            if ($("#filelist").text() != "") {
                                                var trid = $("#filelist tr").attr("id");
                                                //var fileName = delpagefile(trid);//删除页面数据
                                            }
                                            if (file.size != "") {
                                                var showStr = "<tr id='" + trid + "'><td class='td1'><a target='_blank' href='" +data.path+ file.name + "'>" + file.name + "</a></td>";

                                                showStr += "<td class='td2'><span>" + Math.round(file.size/1024) + " KB</span></td>";
                                                showStr += "<td class='td2'><input type='button' onclick='delFiles(\"" + trid + "\")' /></td></tr>";

                                                var filelist = $("#filelist").html();

                                                $("#filelist").attr("class", okMsgclass);
                                                $("#filelist").html(filelist + showStr);
                                            }
                                        }
                                    });
                                });
                            }

                        </script>

                        <div><input type="file" name="fuUpload_fileUpload" id="fuUpload_fileUpload"/></div>

                        <div id="fuUpload_plSizeLimit" style="float: left;">


                        </div>

                        <a href="javascript:$('#fuUpload_fileUpload').uploadify('upload','*')">上传</a> | <a
                            href="javascript:$('#fuUpload_fileUpload')..uploadify('cancel', '*')">清除队列</a>

                        <span class="STYLE9">(附件请限制在10MB以内)</span>
                        <table id="filelist" width="100%" cellspacing="0">
                        </table>
                    </td>
                </tr>
                <tr style="background-color: #ebedfa;">
                    <td style="height: 30px;" align="center" colspan="4">
                        <table>
                            <tr>
                                <td>
                                    <table height='16px' width='40' border='0' cellpadding='0' cellspacing='0'
                                           style='text-align: center; vertical-align:middle; background-color:#eaeaea'>
                                        <tr>
                                            <td width='4'><img src='images/cxw-01.jpg' width='4' height='16px'>
                                            </td>
                                            <td align='center' valign='bottom' background='images/cxw-02.jpg'
                                                width='35px;'>
                                                <a onclick="return checkForm();" id="lnkAdd"
                                                   href="javascript:__doPostBack('lnkAdd','')">提交</a>
                                            </td>
                                            <td><img src='images/cxw-04.gif' width='4' height='16px'></td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    &nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <table height='16px' width='40' border='0' cellpadding='0' cellspacing='0'
                                           style='text-align: center; vertical-align:middle; background-color:#eaeaea'>
                                        <tr>
                                            <td width='4'><img src='images/cxw-01.jpg' width='4' height='16px'>
                                            </td>
                                            <td align='center' valign='bottom' background='images/cxw-02.jpg'
                                                width='35px;'><a
                                                    onclick="document.getElementById('form1').reset();insertData2('');"
                                                    class="lnkbtn">重置</a></td>
                                            <td><img src='images/cxw-04.gif' width='4' height='16px'></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br/>
        </td>
    </tr>
</table>
</div>
</form>
</body>
</html>
