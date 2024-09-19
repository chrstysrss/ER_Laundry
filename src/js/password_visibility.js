
var passIcon = $('.input-password [name="password"] ~ i');
var confirmPassIcon = $('.input-password [name="confirmPass"] ~ i');

passIcon.on( "click", function() {
  if($('[name="password"]').attr('type') == "password"){
    $('[name="password"]').attr('type', 'text');
    passIcon.removeClass("fa-eye").addClass("fa-eye-slash");
  }else{
    $('[name="password"]').attr('type', 'password');
    passIcon.removeClass("fa-eye-slash").addClass("fa-eye");
  }
});

confirmPassIcon.on( "click", function() {
  if($('[name="confirmPass"]').attr('type') == "password"){
    $('[name="confirmPass"]').attr('type', 'text');
    confirmPassIcon.removeClass("fa-eye").addClass("fa-eye-slash");
  }else{
    $('[name="confirmPass"]').attr('type', 'password');
    confirmPassIcon.removeClass("fa-eye-slash").addClass("fa-eye");
  }
});