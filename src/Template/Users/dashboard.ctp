<!-- <script src="<?php echo $this->Url->build('/js/jquery-1.10.1.min.js');?>"></script> -->
<script src="http://demo.itsolutionstuff.com/plugin/croppie.js"></script>
<link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/croppie.css">



<script type="text/javascript">
$uploadCrop = $('#upload-demo').croppie({
    enableExif: true,
    viewport: {
        width: 100,
        height: 100,
        type: 'circle'
    },
    boundary: {
        width: 300,
        height: 300
    }
});

$('#upload').on('change', function () { 
  var reader = new FileReader();
    reader.onload = function (e) {
      $uploadCrop.croppie('bind', {
        url: e.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
      
    }
    reader.readAsDataURL(this.files[0]);
});

$('.upload-result').on('click', function (ev) {
  $uploadCrop.croppie('result', {
    type: 'canvas',
    size: 'viewport'
  }).then(function (resp) {

    $.ajax({
      url: '<?php echo $this->request->webroot;?>'+"users/thumbimage",
      type: "POST",
      data: {"image":resp},
      success: function (data) {
       var obj = $.parseJSON(data);
       if(obj.Ack == 1){       
          $('#profile_image').attr('src', '<?php echo $this->request->webroot;?>user_img/thumb_'+obj.image);         
          $('#myModal').modal('hide');
       }
      }
    });
  });
});

</script>