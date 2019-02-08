$(document).ready(function(){
  if($('#new_order').val() > 0){
    $('#notification').get(0).play();
  }
  //Menu extras modais
  $('.modal').modal({
    dismissible: false,
    complete: function() { $("#form_menu").submit(); }
  });

  //drawer navigation for menu view
  $(".med-menu").sideNav({
    edge: 'right'
  });
  $('.dropdown-button-med-menu').click(function() {
      $('.med-menu').sideNav('show');
   });

  //drawer navigation for mobile view
  $(".mobile-menu").sideNav();
  $('.slider').slider({
    height:350,
    indicators:false
  });

  //Menu items for med view
  $('.tabs').tabs();
  if($('#active_tab').val() != ''){
    if($('#tabs-med').is(":visible")){
      window.location = '../#'+$('#active_tab').val()+'-tab-med';
    }else{
      window.location = '../#'+$('#active_tab').val()+'-tab-mobile';
    }
    $('.tabs').tabs('select_tab', $('#active_tab').val()+'-mobile');
    $('#'+$('#active_tab').val()+'-tab-med').addClass('active');
  }else{
    $('#tabs-med').children().first().children().first().addClass('active');
  }

  $('.collapsible').collapsible();
  $('select').material_select();

  //Masks
  $('.currency').maskMoney({prefix:'£ ', allowNegative: false, thousands:',', decimal:'.', affixesStay: true});
  $('.number').maskMoney({precision: 0, allowEmpty: true, thousands:'', decimal:''});
  $('.phone').mask('0000-000000', {reverse: true});
  $('.time').mask('00:00', {reverse: true});

  toast();
});

//Message Toast
function toast(){
  Materialize.toast($('.msg-text').val(), 5000, $('.msg-class').val()); 
  $('.toast').click(function() {
	    Materialize.Toast.removeAll();
   });
}

function sliderPrev(){
  $('.slider').slider('pause');
  $('.slider').slider('prev');
}

function sliderNext(){
  $('.slider').slider('pause');
  $('.slider').slider('next');
}

//Remove masks on submit
function removeMasks(){
  $('.currency').val($('.currency').maskMoney('unmasked')[0]);
  $('.phone').unmask('0000-0000');
}

//Firebase Email Signin
async function signin() {
  let email = $('#email').val();
  let password = $('#password').val();
  if(email == '' || password == ''){
    $('.msg-text').val('All fields must be informed.');
    $('.msg-class').val('red white-text');
    toast();
  }else{
    let creds = await firebase.auth().signInWithEmailAndPassword(email, password)
      .catch(function(error) {
        $('.msg-text').val(error.message);
        $('.msg-class').val('red white-text');
        toast();
      });
    let token = await creds.user.getIdToken();
    $('#idToken').val(token);
    $('#provider').val('email');
    $("#form_login").submit();
  }
}