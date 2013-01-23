// JScript 文件
/// <reference parh="jquery.jgrowl_minimized.js">
//document.write(" <script type='text/javascript' src='jquery.jgrowl_minimized.js'></script>");
var okMsgclass = "OkMsg"
function UploadSelect(event, queueID, fileObj)
{
//    var type = fileObj.type.toLowerCase();

//    if (type != '.jpg' && type != '.gif' && type != '.png')
//    {
//        alert('Please upload a JPG, GIF, or PNG file.');

//        $("#<%=FileUpload.FileUploadID %>").fileUploadCancel(queueID);
//        
//        event.stopPropogation();
//    }
}

function to2bits(flt)
{ 
    if(parseFloat(flt) == flt) 
        return Math.round(flt * 100) / 100; 
    // 到4位小数, return Math.round(flt * 10000) / 10000; 
    else 
        return 0; 
}

function UploadComplete(event, queueID, fileObj, response, data)
{
    var newfilename = response;
    var oldfilename = fileObj.name;
    var size = to2bits(fileObj.size/1024);
    
    addFiles(queueID,oldfilename,newfilename,size);
}

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

//获取所有已上传的文件url（新文件名）
function getNewFileNames()
{
    var newfileNames = "";
    var count = $("#filelist a").length;
    if(count > 0)
    {
        for(var i=0;i < count;i++)
        {
            var tmp = $("#filelist a:eq(" + i + ")").attr("href").split('/');
            newfileNames += tmp[tmp.length-1] + ";";
        }
    }
    return newfileNames;
}
//获取所有已上传的原文件名
function getOldFileNames()
{
    var oldfileNames = "";
    var count = $("#filelist a").length;
    if(count > 0)
    {
        for(var i=0;i < count;i++)
        {
            oldfileNames += $("#filelist a:eq(" + i + ")").text() + ";";
        }
    }
    return oldfileNames;
}
//获取所有已上传的文件大小（包含KB，需删除）
function getFileSizes()
{
    var fileSizes = "";
    var count = $("#filelist span").length;
    if(count > 0)
    {
        for(var i=0;i < count;i++)
        {
            fileSizes += $("#filelist span:eq(" + i + ")").text() + ";";
        }
    }
    return fileSizes;
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
//添加数据库文件
function addDBFile(oldfileName,newfileName,fileSize)
{
    var mainid = gethfMainID().val();
    var flag = gethfFlag().val();
    
    var tmp = $.ajax(
    {
        type:"POST",
        async: false,
        contentType:"application/json",
        url:"../Services/AjaxService.asmx/AddDBFile",
        data:"{mainid:'" + mainid + "',oldfileName:'" + oldfileName + "',newfileName:'" + newfileName + "',fileSize:'" + fileSize + "',flag:'" + flag + "'}",
        dataType:'json'
    });
    return tmp.responseText;
}
//删除页面所显示文件
function delpagefile(trid)
{
    $("#" + trid).fadeOut(250,function() {
            $("#" + trid).remove();
            if($("#filelist").text() == "")
            $("#filelist").attr("class","");
            })
    var tmp = $("#" + trid + " a").attr("href").split('/');
    var fileName = tmp[tmp.length-1];
    
    return fileName
}
//删除服务器所存文件
function delRealFile(fileName)
{
    var folder = getFolder();
    $.ajax(
    {
        type:"POST",
        contentType:"application/json",
        url:"../Services/AjaxService.asmx/DelFile",
        data:"{fileName:'" + fileName + "',folder:'" + folder + "'}",
        dataType:'json'
    });
}

//删除数据库所存文件
function delDBFile(fileName)
{
    $.ajax(
    {
        type:"POST",
        contentType:"application/json",
        url:"../Services/AjaxService.asmx/DelDBFile",
        data:"{fileName:'" + fileName + "'}",
        dataType:'json'
    });
}

function UploadCancle(event,queueID,fileObj,data)
{
    var msg = "被取消的文件: "+fileObj.name;
	$.jGrowl('<p></p>'+msg, {
		theme: 	'warning',
		header: '取消上传',
		life:	4000,
		sticky: false
	});
}

function UploadError(event, queueID, fileObj, errorObj)
{
    var msg;
	if (errorObj.status == 404) {
		msg = '无法找到上传脚本';
	} else if (errorObj.type === "HTTP")
		msg = errorObj.type+": "+errorObj.status;
	else if (errorObj.type ==="File Size")
		msg = fileObj.name+'文件大小超过: '+Math.round(errorObj.sizeLimit/1048576)+'MB';
	else
		msg = errorObj.type+": "+errorObj.text;
	
    alert(msg);
    var objID = getUploadId();
	$(objID + queueID).fadeOut(250, function() { $(objID + queueID).remove()});
	return false;
}

function ClearQueue(event,data)
{
    //var msg = "Cleared "+data.fileCount+" files from queue";
    alert("ggg")
//	$.jGrowl('<p></p>'+msg, {
//		theme: 	'warning',
//		header: 'Cleared Queue',
//		life:	4000,
//		sticky: false
//	});
}