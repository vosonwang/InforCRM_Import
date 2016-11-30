/**
 * Created by voson on 2016/11/24.
 */
//依赖cookie.js

jQuery(function () {
    var $ = jQuery,
        $list = $('#thelist'),
        $btn = $('#ctlBtn'),
        state = 'pending',
        uploader;


    uploader = WebUploader.create({


        // 文件接收服务端。
        server: 'Import',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#picker',

        // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        resize: false,

        //是否选择完文件，自动上传
        auto:true,

        // 在选择图片时，只能查看到符合条件的文件格式,chrome支持，IE\FIREFOX不支持；对MIME的支持似乎也不好csv无法识别
        // 选择完图片后，会验证是否符合条件，如果类型不符合，会被upload.on('error', handler)捕获。
        accept:{
            title:'From',
            extensions:'xlsx,csv,xls',
            mimeTypes:'application/vnd.ms-excel,1text/plain,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        }
    });

    // 当有文件添加进来的时候
    uploader.on( 'fileQueued', function( file ) {
        $list.append( '<div id="' + file.id + '" class="item">' +
            '<h4 class="info">' + file.name + '</h4>' +
            '<p class="state">等待上传...</p>' +
            '</div>' );
    });

    // 文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {
        var $li = $( '#'+file.id ),
            $percent = $li.find('.progress .progress-bar');

        // 避免重复创建
        if ( !$percent.length ) {
            $percent = $('<div class="progress progress-striped active">' +
                '<div class="progress-bar" role="progressbar" style="width: 0%">' +
                '</div>' +
                '</div>').appendTo( $li ).find('.progress-bar');    /*加入上传进度条*/
        }

        $li.find('p.state').text('上传中');

        $percent.css( 'width', percentage * 100 + '%' );
    });

    uploader.on( 'uploadSuccess', function( file,response ) {
        //根据服务端返回的数据，判断是否被服务器成功接收
        if(response=='1'){
            $( '#'+file.id ).find('p.state').text('上传成功');

            /*将文件名写入cookie*/
            SetCookie('filename',file.name);
        }else{
            $( '#'+file.id ).find('p.state').html(response.error).addClass('error');
        }
    });

    uploader.on( 'uploadError', function( file ,reason) {
        $( '#'+file.id ).find('p.state').text('上传出错,请联系管理员');
        console.log(reason)
    });

    uploader.on( 'uploadComplete', function( file) {
        /*隐藏进度条*/
        $( '#'+file.id ).find('.progress').fadeOut();
    });

    uploader.on('error',function (type) {
       if(type=='Q_TYPE_DENIED'){
           toastr.error('上传的文件类型不正确！');
       }
    });


    uploader.on( 'all', function( type ) {
        if ( type === 'startUpload' ) {
            state = 'uploading';
        } else if ( type === 'stopUpload' ) {
            state = 'paused';
        } else if ( type === 'uploadFinished' ) {
            state = 'done';
        }

        if ( state === 'uploading' ) {
            $btn.text('暂停上传');
        } else {
            $btn.text('开始上传');
        }
    });

    $btn.on( 'click', function() {
        if ( state === 'uploading' ) {
            uploader.stop();
        } else {
            uploader.upload();
        }
    });


});
