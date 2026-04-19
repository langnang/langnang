<div class="list-group text-center" style="position: fixed; bottom: 62px; width: 64px; right: 10px; z-index: 999;">
  <a href="#" class="list-group-item" data-toggle="tooltip" data-placement="left" title="站点收录">
    <h4 class="list-group-item-heading">
      <i class="glyphicon glyphicon-plus-sign"></i>
    </h4>
  </a>
  <a href="#" class="list-group-item" data-toggle="tooltip" data-placement="left" title="Tooltip on left">
    <h4 class="list-group-item-heading">
      <i class="glyphicon glyphicon-chevron-up"></i>
    </h4>
  </a>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">站点收录</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>地址：</label>
              <div class="input-group">
                <input type="text" class="form-control" name="url">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button" style="border: 1px solid #ccc;"
                    onclick="handleSpiderContent()">
                    <i class="fa-solid fa-spider"></i>
                  </button>
                </span>
              </div><!-- /input-group -->
            </div>
            <div class="form-group">
              <label>标题：</label>
              <input type="text" class="form-control" name="title">
            </div>
            <div class="form-group">
              <label>徽标：</label>
              <input type="text" class="form-control" name="icon">
            </div>
            <div class="form-group">
              <label>描述：</label>
              <input type="text" class="form-control" name="description">
            </div>
          </div>
          <div class="col-md-6">
            @include('_shared.checkbox', [
                'name' => 'mids',
                'checkboxes' => $tree ?? [],
                'props' => ['value' => 'mid', 'label' => 'name'],
            ])
          </div>
        </div>
      </div>
      <div class="modal-footer text-center">
        <button type="button" class="btn btn-info" data-dismiss="modal" onclick="handleCancelContent()">取消</button>
        <button type="button" class="btn btn-primary" onclick="handleSubmitContent()">提交</button>
      </div>
    </div>
  </div>
</div>
{{-- @include('_layout.modal.import') --}}
<!-- 锚点平滑移动 -->
<script type="text/javascript">
  $(document).ready(function() {
    //img lazy loaded
    const observer = lozad();
    observer.observe();

    $(document).on('click', '.has-sub', function() {
      var _this = $(this)
      if (!$(this).hasClass('expanded')) {
        setTimeout(function() {
          _this.find('ul').attr("style", "")
        }, 300);

      } else {
        $('.has-sub ul').each(function(id, ele) {
          var _that = $(this)
          if (_this.find('ul')[0] != ele) {
            setTimeout(function() {
              _that.attr("style", "")
            }, 300);
          }
        })
      }
    })
    $('.user-info-menu .hidden-sm').click(function() {
      if ($('.sidebar-menu').hasClass('collapsed')) {
        $('.has-sub.expanded > ul').attr("style", "")
      } else {
        $('.has-sub.expanded > ul').show()
      }
    })
    $("#main-menu li ul li").click(function() {
      $(this).siblings('li').removeClass('active'); // 删除其他兄弟元素的样式
      $(this).addClass('active'); // 添加当前元素的样式
    });
    $("a.smooth").click(function(ev) {
      ev.preventDefault();

      public_vars.$mainMenu.add(public_vars.$sidebarProfile).toggleClass('mobile-is-visible');
      ps_destroy();
      $("html, body").animate({
        scrollTop: $($(this).attr("href")).offset().top - 30
      }, {
        duration: 500,
        easing: "swing"
      });
    });
    return false;
  });

  var href = "";
  var pos = 0;
  $("a.smooth").click(function(e) {
    $("#main-menu li").each(function() {
      $(this).removeClass("active");
    });
    $(this).parent("li").addClass("active");
    e.preventDefault();
    href = $(this).attr("href");
    pos = $(href).position().top - 30;
  });
</script>
<!-- Bottom Scripts -->
<script src="/public/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/public/vendor/TweenMax/TweenMax.min.js"></script>
<script src="/public/vendor/resizeable.js"></script>
<script src="/public/vendor/autosize/autosize.min.js"></script>
<script src="/public/vendor/joinable.js"></script>
<script src="/public/vendor/xenon/js/xenon-api.js"></script>
<script src="/public/vendor/xenon/js/xenon-toggles.js"></script>
<!-- JavaScripts initializations and stuff -->
<script src="/public/vendor/xenon/js/xenon-custom.js"></script>
<script src="/public/vendor/lozad/lozad.min.js"></script>
<script src="/public/vendor/axios/axios.min.js"></script>
<script>
  function handleSpiderContent() {
    const url = $('#myModal [name=url]').val();
    console.log("🚀 ~ file: foot.blade.php:131 ~ handleSpiderContent:", {
      url
    });
    axios.post('/api/spider/origin', {
      url
    })

  }

  function handleSubmitContent() {
    const data = {
      url: $('#myModal [name=url]').val(),
      title: $('#myModal [name=title]').val(),
      icon: $('#myModal [name=icon]').val(),
      description: $('#myModal [name=description]').val(),
      mids: [],
    }
    $('#myModal [name=mids]:checked').each(function() {
      data.mids.push($(this).val());
    });


    console.log("🚀 ~ file: foot.blade.php:131 ~ handleSubmitContent:", data);
    axios({
      url: '/api/webstack/insert_content_item',
      data,
      method: 'post',
    }).then(res => {
      console.log(res);
    })
  }

  function handleCancelContent() {
    console.log("🚀 ~ file: foot.blade.php:138 ~ handleCancelContent:", );

  }
</script>
