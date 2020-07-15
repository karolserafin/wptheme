<form id="contact" class="contact-form" method="POST" novalidate="novalidate">
	<p class="form-title">Formularz kontaktowy</p>
		
		<div class="form__response"><span></span></div>

		<div class="uk-margin uk-position-relative form__field">
			<select name="subject" id="subject" class="uk-select">
				<?php $subjects = wctheme_get_contact_email_subjects(); ?>
				<option value=""><?php _e('Wybierz temat...', 'wctheme'); ?></option>
				<?php for ($i = 1; $i <= count($subjects)-1; $i++) : ?>
					<option value="<?php echo $i; ?>"><?php echo $subjects[$i]; ?></option>
				<?php endfor; ?>
			</select>
		</div>	
		<div class="uk-margin uk-position-relative form__field">
			<input class="uk-input" name="name" id="name" type="text" placeholder="<?php _e( 'Imie i nazwisko lub nazwa firmy*', 'wctheme' ) ?>">
		</div>

		<div class="uk-margin uk-position-relative form__field">
			<input class="uk-input" name="email" id="email" type="email" placeholder="<?php _e( 'Adres e-mail do odpowiedzi*', 'wctheme' ) ?>">
		</div>				

		<div class="uk-margin uk-position-relative form__field">
			<input class="uk-input" name="phone" id="phone" type="text" placeholder="<?php _e( 'Telefon', 'wctheme' ) ?>">
		</div>

		<div class="uk-margin uk-position-relative form__field">
			<textarea r_min="3" r_max="4" class="uk-textarea require-this" name="message" id="message" cols="30" rows="10" placeholder="<?php _e( 'Wiadomość', 'wctheme' ); ?>"></textarea>
		</div>
		
		<label class="rules form__field" for="rules">
			<input type="checkbox" name="rules" id="rules" class="uk-checkbox" />
			<span><?php printf( __( 'Akceptuję <a href="%1$s">Politykę prywatności</a> i <a href="%2$s">Regulamin</a>' ), get_privacy_policy_url(), get_terms_and_conditions_url() ); ?></span>
		</label>

		<div class="button-container">
			<button id="send__email" class="button button--empty"><?php _e( 'Wyślij', 'wctheme' ); ?></button>	
		</div>
	
</form>

<script type="text/javascript">
	jQuery(document).ready( function($) {
	   
	   var contactForm = $('form#contact');
	   contactForm.validate({
	   		rules: {
	   			subject: {
	   				required: true
	   			},
	   			name: {
	   				required: true
	   			},
	   			email: {
	   				required: true,
	   				email: true
	   			},
	   			phone: {
	   				minlength: 9,
	   				maxlength: 9,
	   				number: true
	   			},
	   			rules: {
	   				required: true
	   			}
	   		},
	   		messages: {
	   			subject: {
	   				required: 'Pole wymagane'
	   			},
	   			name: {
	   				required: 'Pole wymagane'
	   			},
	   			email: {
	   				required: 'Pole wymagane',
	   				email: 'Wprowadź prawidłowy adres e-mail'
	   			},
	   			phone: {
	   				minlength: 'Nr telefonu musi mieć 9 cyfr',
	   				maxlength: 'Nr telefonu musi mieć 9 cyfr',
	   				number: 'Nr telefonu musi składać się wyłącznie z cyfr'
	   			},
	   			rules: {
	   				required: 'Pole wymagane',
	   			}
	   		},
	   		errorElement: 'span',
	   		errorPlacement: function(error, element) {
	   			
	   			if ( $(element).parent().prop("tagName").toLowerCase() == "label" ) {
	   				$(element).parent().after(error);
	   			} else {
	   				$(element).parent().append(error);
	   			}

	   		},
	   		highlight: function(element, errorClass, validClass) {
	        	$(element).parent('.form__field').addClass("has-error");
	      	},
	      	unhighlight: function(element, errorClass, validClass) {
	        	$(element).parent('.form__field').removeClass("has-error");
	      	}
	   });

	   $('#send__email').on('click', function(e) {

	   		e.preventDefault();
	   		var formValid = contactForm.valid();

	   		if ( formValid ) {

	   			$('#send__email').text('Wysyłanie...');

	   			$.ajax({
	        		type: 'post',
	        		dataType: 'json',
	        		url: ajaxurl,
	        		data: { 
	         			action: 'wctheme_contact_form',
	         			subject: $('#subject').val(),
	         			name: $('#name').val(),
	         			email: $('#email').val(),
	         			phone: $('#phone').val(),
	         			message: $('#message').val(),
	         			rules: $('#rules').val(),
	         		},
	         		success: function(response) {
	         			
	         			$('#send__email').text('Wyślij');

	         			if ( response.success ) {
	         				$('.form__response').addClass('form__response--success');
	         				$('.form__response span').text( response.success.message );
	         				$('.form__response').show();
	         			}

	         			if ( response.error ) {
	         				$('.form__response').addClass('form__response--error');
	         				$('.form__response span').text( response.error.message );
	         				$('.form__response').show();
	         			}

	         			setTimeout(function() {

	         				if ( $('.form__response').hasClass('form__response--success') ) {
	         					$('.form__response').removeClass('form__response--success');
	         					$("form#contact").trigger('reset');
	         				} else {
	         					$('.form__response').removeClass('form__response--error');
	         				}

	         				$('.form__response').hide();
	         				$('.form__response span').text('');

	         			}, 5000);

	         		}

	      		});

	   		}

	   });

	});
</script>