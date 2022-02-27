let validationIgnore = false;

let pass = false;

$(document).on("submit", "form", function(){

  if(validationIgnore)
    return true;


  pass = true; 
  let email_exp =  /^([\w-\.]+@([\w-]+\.)+[\w-]{2,8})?$/; 
  let password = /^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])[a-zA-Z0-9\w#!:.?+=&%@$!\-\/]{8,}$/;
  
  $(document).find('.error-box').remove();
  $(document).find('.error').removeClass('error');

  $(this).find('input, select, textarea').each(function(event){

    if( $(this).hasClass('required') && $(this).val()=='' && !$(this).hasClass('only-one'))
    {

      $(this).addClass('error');
      if($(this).hasClass('mn'))
        $(this).parent().after('<div class="error-box"><span class="lable-error error">This is a mandatory field.</span></span>');
      else
        $(this).after('<span class="error-box"><span class="lable-error error">This is a mandatory field.</span></span>');
      pass = false;
    }
    else
    if(($(this).hasClass('password') && $(this).val()!='' && !$(this).val().match(password)))
    {
      $(this).addClass('error');
      $(this).after('<span class="error-box"><span class="lable-error error">Password should have atleast one number, one lower case, one upper case character and atleast 8 characters.</span></span>');
      pass = false;
    }
    else
    if(($(this).hasClass('email') && $(this).val()!='' && !$(this).val().match(email_exp)))
    {
      $(this).addClass('error');
      $(this).after('<span class="error-box"><span class="lable-error error">Please enter valid email.</span></span>');
      pass = false;
    }
 

    if(($(this).attr('type')=='text' || $(this).attr('type')=='radio' || $(this).attr('type')=='checkbox') && $(this).hasClass('required') && $(this).hasClass('only-one')){
        
        let checkOne = false;
        let targetClass = $(this).attr('data-target-class');
        
        $(document).find('.'+targetClass).each(function () {
          
          if($(this).attr('type')!='text'){
            
            if($(this).prop('checked')){
                checkOne = true;
            }
          }
          else{
            
            if($(this).val()!=''){
              checkOne = true;
            }
          
          }
  
        });

        if(!checkOne)
        {
            $(this).addClass('error');
            
            $(document).find('.'+targetClass+'-error').html('<span class="error-box"><span class="lable-error error">This is a mandatory field.</span></span>');
           
            pass = false;

        }
        
    }

    if($(this).parent().hasClass('required') && $(this).parent().hasClass('dropdown')){
      
      if($(this).dropdown('get value').length==0){
        $(this).addClass('error');
        $(this).parent().after('<span class="error-box"><span class="lable-error error">This is a mandatory field.</span></span>');
        pass = false;
      }
    }
  });

  console.log('pass '+pass);
  if(pass==false){

    $("html, body").animate({
        scrollTop: $(".error-box").offset().top - 250
      }, 1000);
    return false;
  } 
  return pass;

});

$(document).on('click','input, select, textarea', function(){
    
    if($(this).hasClass('error')){
        
        $(this).parent().parent().find('.error-box').remove();
        $(this).removeClass('error');
        if($(this).hasClass('only-one')){
          $(document).find('.'+$(this).attr('data-target-class')+'-error').html('');
        }
    }
});
$(document).on('click','.error-box', function(){
    $(this).remove();
});


