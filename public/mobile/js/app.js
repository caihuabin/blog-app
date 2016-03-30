(function($){
    var Blog = {

        init: function(){
            var self = this;
            window.addEventListener('push', function(e) {
                self.siteBootUp(e);
            });
            self.siteBootUp();

        },
        /*
        * Things to be execute when normal page load
        * and pjax page load.
        */
        siteBootUp: function(e){
            var self = this;
            /*if(e == undefined){
            }
            else{
            	console.log(e.detail.state.url);
                console.log(window.location.pathname);
            }*/
            self.initTimeAgo();
            self.restfulForm();
            self.disabledSubmit();
            self.pullToRefresh();
            //self.ratingStar();
            if(window.location.pathname.indexOf('/blog/create') > -1 ){
                self.CreateBlog();
                self.initUploadFile();
            }
            if(/\/blog\/\d+\/edit/.test(window.location.pathname)){
                self.updateBlog();
                self.initUploadFile();
            }
            if(/\/blog\/(\d)+/.test(window.location.pathname)){
                self.initImageLightbox();
            }
            if(/\/user\/\d+\/edit/.test(window.location.pathname)){
                self.toggleButton();
                self.initUploadFile();
            }
            
            
        },

        initTimeAgo: function(){
            moment.locale('zh-cn');
            $('.timeago').each(function(){
                var time_str = $(this).text();
                if(moment(time_str, "YYYY-MM-DD HH:mm:ss", true).isValid()) {
                    $(this).text(moment(time_str).fromNow());
                }
            });
        },
        restfulForm: function(){
            $('[data-method]').not(".disabled").append(function(){
                var methodForm = "\n"
                methodForm += "<form action='"+$(this).attr('data-url')+"' method='POST' style='display:none'>\n"
                methodForm += " <input type='hidden' name='_method' value='"+$(this).attr('data-method')+"'>\n"
                if ($(this).attr('data-token')) 
                { 
                    methodForm +="<input type='hidden' name='_token' value='"+$(this).attr('data-token')+"'>\n"
                }
                methodForm += "</form>\n"
                return methodForm
            })
            /*.removeAttr('href')*/
            .attr('onclick',' if ($(this).hasClass(\'action_confirm\')) { if(confirm("Are you sure you want to do this?")) { $(this).find("form").submit(); } } else { $(this).find("form").submit(); }');
        },
        disabledSubmit: function(){
            $('form').submit(function(){
                var $submit = $(this).find('[type=submit]');
                if($submit.length){
                    $submit.attr('disabled', 'disabled');
                }
            });
        },
        toggleButton: function(){
            var genderToggle = document.getElementById('genderToggle')
            if(genderToggle){
                genderToggle.addEventListener('toggle', function(e) {
                    if(e.detail.isActive){
                        $('input[name=gender]').val(0);
                    }
                    else{
                        $('input[name=gender]').val(1);
                    }
                    /*"Event subscriber on "+e.currentTarget.nodeName+", "
                    +e.detail.time.toLocaleString()+": "+e.detail.message*/
                });
            }
        },

        ratingStar: function(){
            $('.ui.rating.enable').rating();
        },
        pullToRefresh: function(){
            var self = this;
            var opts = {
                nav: '#pullHeader',
                scrollEl: '#pullContent',
                onBegin: function(){
                    console.log('Begin refresh');
                },
                onEnd: function(){
                    console.log('End refresh');
                },
                maxTime: 2000,
                //freeze: true
            }
            mRefresh(opts);

            $('.refreshAction').on('tap click', function(){
                mRefresh.refresh();
            });
             // prevent browser scroll
            /*$('#pullHeader').on('touchstart', function(e){
                 e.preventDefault();
            });
            // Handle the start of interactions
            $('#pullContent').on('touchmove', function(e){
                var el = document.getElementById("pullContent");
                var startTopScroll = el.scrollTop;

                if (startTopScroll <= 0) {
                    el.scrollTop = 1;
                }
                if(startTopScroll + el.offsetHeight >= el.scrollHeight) {
                    el.scrollTop = el.scrollHeight - el.offsetHeight - 1;
                }
            });*/
            /*  var opts = { 
                    nav: '', //String, using for Type2 
                    scrollEl: '', //String  
                    onBegin: null, //Function 
                    onEnd: null, //Function 
                    top: '0px', //String 
                    theme: 'mui-blue-theme', //String 
                    index: 10001, //Number
                    maxTime: 6000, //Number 
                    freeze: false //Boolen 
                } 
                mRefresh(opts);
            */
        },
        CreateBlog: function(){
            $('#createBlog').off('click').on('click',function(e){
                if ($(e.currentTarget).hasClass('action_confirm'))
                {
                    if(confirm("Are you sure you want to do this?")) 
                    {
                        $("#blogForm").submit();
                    }
                }
                else
                {
                    $("#blogForm").submit();
                }

            });
        },
        updateBlog: function(){
            $('#updateBlog').off('click').on('click',function(e){
                if ($(e.currentTarget).hasClass('action_confirm'))
                {
                    if(confirm("Are you sure you want to do this?")) 
                    {
                        $("#blogForm").submit();
                    }
                }
                else
                {
                    $("#blogForm").submit();
                }

            });
        },

        initUploadFile: function(){
            var _template = '<img src="[[src]]"/><span class="progress"></span><span class="percentage">0%</span>';

            var _imgboxEle = $('#show_image');
            var self = this;
            var fileInput = document.getElementById('imagefile');
            (fileInput != null) && (fileInput.onchange = function(e){
                            var file = this.files[0];
                            if (file.type.match(/image*/))
                            {
                                var reader = new FileReader();
                                reader.onload = function (e)
                                {
                                    var div = document.createElement("div");
                                    div.innerHTML = _template.replace("[[src]]", e.target.result);
            
                                    var form = document.getElementById('imageUploadForm');
                                    
                                    if($(form).attr('data-input') === 'image_list'){
                                        div.classList.add('grid-u-1-3');
                                        _imgboxEle.append(div);
                                    }
                                    else{
                                        _imgboxEle.html(div);
                                    }
                                    
                                    self._ajaxSubmit(form, div);
                                };
                                reader.readAsDataURL(file);
                            }
                            else
                            {
                                console.log(file.name + "is not an image");
                            }
                            
                        })
            
        },

        _ajaxSubmit: function(form, div){
            var formData = new FormData(form);
            var xhr = this._createStandardXHR();
            xhr.open("POST", Config.routes.upload_image_url, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest', 'Content-Type', 'multipart/form-data;');
            var imgHeight = div.children[0].offsetHeight;
            var progress = div.children[1];
            var percentage = div.children[2];
            xhr.upload.onprogress = function (e)
            {
                var percent = 0;
                if (e.lengthComputable)
                {
                    percent = 100 * e.loaded / e.total;
                    progress.style.height = percent/100*imgHeight + "px";
                    percentage.innerText = percent + "%";
                    percent >= 100 && div.classList.add("done");
                }
            };
            xhr.onload = function(e){
                var data = JSON.parse(e.currentTarget.response);
                /*console.log(data);*/
                if(data['error']){
                    alert( data['error']);
                    return;
                }
                switch($(form).attr('data-input')){
                    case 'image_list':
                        var image_size = document.getElementById('image_list').children.length;
                        var last_image,input_name;

                        if(image_size){
                            last_image = document.getElementById('image_list').children[image_size-1];
                            input_name = last_image.getAttribute('name').replace(/\d+/,function(value,index){return parseInt(value)+1});
                        }
                        else{
                            input_name = "image_list[0]";
                        }
                        var inputStr = "<input type='hidden' name='"+ (input_name) +"' value='"+data[0]+"'/>";
                        $('#image_list').append(inputStr);
                        break;
                    case 'avatar':
                        /*$('#avatar_img').attr('src', data[0].replace('.','-clip.'));*/
                        var index = data[0].lastIndexOf('.');
                        
                        $('#avatar').val(data[0].substr(0,index) + '-clip' + data[0].substr(index,data[0].length-index));
                        break;
                    default:
                        break;
                }
            };
            xhr.onerror = function(error){
                console.log(error);
            };
            xhr.send(formData);
        },

        _createStandardXHR: function (){
            try {
                return new window.XMLHttpRequest();
            } catch( e ) {}
        },

        initImageLightbox: function(){
            // ACTIVITY INDICATOR
            var activityIndicatorOn = function()
            {
                $( '<div id="imagelightbox-loading"><div></div></div>' ).appendTo( 'body' );
            },
            activityIndicatorOff = function()
            {
                $( '#imagelightbox-loading' ).remove();
            },

            // OVERLAY
            overlayOn = function()
            {
                $( '<div id="imagelightbox-overlay"></div>' ).appendTo( 'body' );
            },
            overlayOff = function()
            {
                $( '#imagelightbox-overlay' ).remove();
            },

            // CLOSE BUTTON
            closeButtonOn = function( instance )
            {
                $( '<button type="button" id="imagelightbox-close" title="Close"></button>' ).appendTo( 'body' ).on( 'click touchend', function(){ $( this ).remove(); instance.quitImageLightbox(); return false; });
            },
            closeButtonOff = function()
            {
                $( '#imagelightbox-close' ).remove();
            },

            // CAPTION
            captionOn = function()
            {
                var description = $( 'a[href="' + $( '#imagelightbox' ).attr( 'src' ) + '"] img' ).attr( 'alt' );
                if( description.length > 0 )
                    $( '<div id="imagelightbox-caption">' + description + '</div>' ).appendTo( 'body' );
            },
            captionOff = function()
            {
                $( '#imagelightbox-caption' ).remove();
            },

            // NAVIGATION
            navigationOn = function( instance, selector )
            {
                var images = $( selector );
                if( images.length )
                {
                    var nav = $( '<div id="imagelightbox-nav"></div>' );
                    for( var i = 0; i < images.length; i++ )
                        nav.append( '<button type="button"></button>' );

                    nav.appendTo( 'body' );
                    nav.on( 'click touchend', function(){ return false; });

                    var navItems = nav.find( 'button' );
                    navItems.on( 'click touchend', function()
                    {
                        var $this = $( this );
                        if( images.eq( $this.index() ).attr( 'href' ) != $( '#imagelightbox' ).attr( 'src' ) )
                            instance.switchImageLightbox( $this.index() );

                        navItems.removeClass( 'active' );
                        navItems.eq( $this.index() ).addClass( 'active' );

                        return false;
                    })
                    .on( 'touchend', function(){ return false; });
                }
            },
            navigationUpdate = function( selector )
            {
                var items = $( '#imagelightbox-nav button' );
                items.removeClass( 'active' );
                items.eq( $( selector ).filter( '[href="' + $( '#imagelightbox' ).attr( 'src' ) + '"]' ).index( selector ) ).addClass( 'active' );
            },
            navigationOff = function()
            {
                $( '#imagelightbox-nav' ).remove();
            },

            // ARROWS
            arrowsOn = function( instance, selector )
            {
                var $arrows = $( '<button type="button" class="imagelightbox-arrow imagelightbox-arrow-left"></button><button type="button" class="imagelightbox-arrow imagelightbox-arrow-right"></button>' );
                $arrows.appendTo( 'body' );
                $arrows.on( 'click touchend', function( e )
                {
                    e.preventDefault();

                    var $this   = $( this ),
                        $target = $( selector + '[href="' + $( '#imagelightbox' ).attr( 'src' ) + '"]' ),
                        index   = $target.index( selector );

                    if( $this.hasClass( 'imagelightbox-arrow-left' ) )
                    {
                        index = index - 1;
                        if( !$( selector ).eq( index ).length )
                            index = $( selector ).length;
                    }
                    else
                    {
                        index = index + 1;
                        if( !$( selector ).eq( index ).length )
                            index = 0;
                    }
                    instance.switchImageLightbox( index );
                    return false;
                });
            },
            arrowsOff = function()
            {
                $( '.imagelightbox-arrow' ).remove();
            };
            var selectorF = 'a[data-imagelightbox="a"]';
            var instanceF = $( selectorF ).imageLightbox(
            {
                onStart:        function() { overlayOn(); closeButtonOn( instanceF ); navigationOn( instanceF, selectorF ); /*captionOff(); arrowsOn( instanceF, selectorF );*/},
                onEnd:          function() { overlayOff(); closeButtonOff(); navigationOff(); /* arrowsOff(); captionOff(); */activityIndicatorOff();},
                onLoadStart:    function() { activityIndicatorOn(); },
                onLoadEnd:      function() { /*captionOn(); $( '.imagelightbox-arrow' ).css( 'display', 'block' ); */ navigationUpdate( selectorF ); activityIndicatorOff(); }
            });
        },

        replyBlog: function(){
            $('#reply_id').val(0);
            $('#reply_content').val('');
            this.moveEnd($("#reply_content"));
        },
        replyOne: function(username, reply_id){
            $('#reply_id').val(reply_id);
            var replyContent = $("#reply_content");
            var oldContent = replyContent.val();
            var prefix = "@" + username + " ";
            var newContent = '';
            if(oldContent.length > 0){
                if (oldContent != prefix) {
                    newContent = oldContent + "\n" + prefix;
                }
            } 
            else {
                newContent = prefix
            }
            replyContent.focus();
            replyContent.val(newContent);
            this.moveEnd($("#reply_content"));
        },
        moveEnd: function(obj){
            obj.focus();
            var len = obj.value === undefined ? 0 : obj.value.length;
            if (document.selection) {
                var sel = obj.createTextRange();
                sel.moveStart('character',len);
                sel.collapse();
                sel.select();
            } else if (typeof obj.selectionStart == 'number' && typeof obj.selectionEnd == 'number') {
                obj.selectionStart = obj.selectionEnd = len;
            }
        }
    	
    }
    window.Blog = Blog;
})(jQuery);

$(document).ready(function()
{
    Blog.init();
});
    //window.addEventListener('push', myFunction);
    //document.querySelector('#mySlider').addEventListener('slide', myFunction)