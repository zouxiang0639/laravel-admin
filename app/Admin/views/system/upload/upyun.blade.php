<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{!!  config('admin.name') !!}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="stylesheet" href="{{  assets_path("/lib/AdminLTE/bootstrap/css/bootstrap.min.css") }}">
    <style>
        .file-upload-btn-wrapper {
            margin-bottom: 10px;
        }

        .file-upload-btn-wrapper .num {
            color: #999999;
            float: right;
            margin-top: 5px;
        }

        .file-upload-btn-wrapper .num em {
            color: #FF5500;
            font-style: normal;
        }

        .files-wrapper {
            border: 1px solid #CCCCCC;
        }

        .files-wrapper ul {
            height: 280px;
            overflow-y: scroll;
            padding-bottom: 10px;
            position: relative;
            margin: 0;
        }

        .files-wrapper li {
            display: inline;
            float: left;
            height: 100px;
            margin: 10px 0 0 10px;
            width: 100px;
            position: relative;
            border:1px solid #CCCCCC;
        }

        .files-wrapper li.selected {
            border: 1px solid #fe781e;
        }
        .files-wrapper li .upload-percent{
            width: 100%;
            height:100%;
            line-height: 100px;
            text-align: center;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }

        .files-wrapper li .selected-icon-wrapper{
            position: absolute;
            top: 0;
            height: 20px;
            font-size: 16px;
            text-align:center;
            line-height:20px;
            color:#fe781e;
            display: none;
        }
        .files-wrapper li.selected .selected-icon-wrapper{
            display: block;
        }
        .files-wrapper li img{
            width: 100%;
            height: 100%;
            vertical-align: top;
        }
    </style>
</head>
<body>

<div class="wrap" style="padding: 5px;">

    <div class="tab-content">
        <div class="tab-pane active" id="upload-file-tab">
            <div class="file-upload-btn-wrapper">
                <!--选择按钮-->
                <div style="display: inline-block;">
                    <a class="btn btn-primary" id="select-files">
                        选择文件
                    </a>
                </div>

					<span class="num">
                        @if($size != '')
						单文件最大<em>{!! $size !!}</em>,
                        @endif
					    支持格式:	<em style="cursor: help;" title="可上传格式：{!! $ext !!}" data-toggle="tooltip">{!! $ext !!}</em>
					</span>
            </div>
            <div class="files-wrapper">
                <ul id="files-container">
                </ul>
            </div>
        </div>

    </div>
</div>
<!-- add new calendar event modal -->
<script src="{{  assets_path("/lib/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
<script src="{{  assets_path("/lib/AdminLTE/bootstrap/js/bootstrap.min.js") }}"></script>
<script src="{{  assets_path("/lib/plupload/plupload.full.min.js") }}"></script>
<script src="{{  assets_path("/lib/plupload/i18n/zh_CN.js") }}"></script>
<script>
    var print_file = $("input[name='print_file']");
    var multi = false;
    var fileDate = '';
    var uploader = new plupload.Uploader({
        browse_button : 'select-files',
        runtimes : 'html5,flash,silverlight',
        url : '{{ $url }}',
        @if($size != '')
        max_file_size : '{!! $size !!}',//100b, 10kb, 10mb, 1gb
        @endif
        multipart_params: {
            'key' : '${filename}', // use filename as a key
            'Filename' : '${filename}', // adding this to keep consistency across the runtimes
            'Content-Type' : '',
            'policy' : '{!! $policy !!}',
            'authorization' : '{!! $authorization !!}'
        },
        multi_selection : multi, //默认true，即可以选择多个文件
        multipart : true,
        flash_swf_url : '{!! assets_path("/lib/plupload/Moxie.swf") !!}',
        silverlight_xap_url : '{!! assets_path("/lib/plupload/Moxie.xap") !!}',

        @if(strpos($ext, 'All') === false)
        filters : {
            mime_types: [
                {
                    title : "Image files",
                    extensions : "{!! $ext !!}"
                }
            ]
        },
        @endif

        init : {
            FilesAdded : function(up, files) {

                var checkNum = 0; //检查文件名称长度
                var stringNum = 33; //文件名称最大字节
                var extNum = 0;

                plupload.each(files, function(file) {
                    if(stringNum < file.name.split(".")[0].length ) {
                        checkNum ++;
                    }
                    if(file.name.split(".")[1]  == undefined) {
                        extNum ++ ;
                    }

                });

                if(extNum >= 1){
                    alert('文件格式错误,没有后缀名!');
                    return false;
                }


                if(checkNum  >=  1) {
                    alert('文件名称不能大于33个字符');
                    return false;
                }

                plupload.each(files, function(file) {

                    var $newfile = $('\
									<li class="selected">\
										<div class="selected-icon-wrapper">'+plupload.formatSize(file.size)+'</div>\
										<div class="upload-percent">0%</div>\
									</li>');
                    $newfile.attr('id',file.id);
                    $('#files-container').append($newfile);
                    $newfile.on('click',function(){
                        var $this = $(this);
                        //$this.toggleClass('selected');
                    });
                });

                uploader.start();
            },
            UploadProgress: function(up, file) {
                $('#'+file.id).find('.upload-percent').text(file.percent+"%");
            },
            FileUploaded: function(up, file, response) {
                var data = JSON.parse(response.response);

                if(data.code == 200){
                    if(!multi) {
                        $('#select-files').css('visibility','hidden');
                        $('.moxie-shim input').attr('disabled',true);
                        $('#container').css('visibility','hidden');
                    }
                    fileDate = {'path' : data.url, 'name' : file.name};
                    var $file=$('#'+file.id);
                    if(data.url.match(/\.(gif|jpeg|jpg|png|bmp|pic)$/gi)){
                        var $img=$('<img/>');
                        $img.attr('src','{!! $imageUrl !!}' + data.url);
                        $file.find('.upload-percent')
                                .html($img);
                    }else{

                        $file.find('.upload-percent').attr('title',file.name).text(file.name);
                    }
                }else{
                    alert(data.msg);
                    $('#'+file.id).remove();
                }
            },
            Error: function(up, err) {
                console.log(err);
                //alert("Error #" + err.code + ": " + err.message);
                alert(err.message);
            }
        }

    });
    uploader.init();
    function getFile()
    {
        return fileDate;
    }

</script>
</body>
</html>

