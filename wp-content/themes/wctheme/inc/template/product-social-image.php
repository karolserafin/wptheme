<?php 

	$i                  = 0;
	$product_id 		= $_GET['product'];
    $wc_product         = wc_get_product( $product_id );
    $gallery            = array();
    $attachment_ids     = $wc_product->get_gallery_image_ids();

    foreach( $attachment_ids as $attachment_id ) {
        $gallery[] = wp_get_attachment_url( $attachment_id );
    }

    $image_id  = $wc_product->get_image_id();
    $image_url = wp_get_attachment_image_url( $image_id, 'full' );

    $cake_variant_size 			= '24cm';
    $cake_variant_customers 	= '16-20 osób';

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Image generator</title>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap">
		<style>
			#canvas-wrapper {
				width: 1200px;
				height: 630px;
				background-color: #000000;
				position: relative;
				font-family: 'Montserrat', sans-serif;
			}
			.icon {
				position: absolute;
				left: 0;
				top: 5px;
			}
			.icon img {
				width: 40px;
				height: auto;
			}
			.icon-small img {
				max-width: 30px;
			}
			.feature {
				position: absolute;
				color: #ffffff;
				font-size: 30px;
				left: 70px;
				top: 130px;
				margin: 0;
				padding-left: 50px;
			}

			.feature--bottom {
				top: 220px;
			}
			.feature--top {
				top: 80px;
			}
			.feature--middle {
				top: 160px;
			}
			.feature--mbottom {
				top: 240px;
			}
			.images {
				width: 400px;
				position: absolute;
				left: 70px;
				bottom: 70px;
			}
			.gallery-image {
				display: inline-block;
				border: 2px solid #bf883b;
				border-radius: 50%;
				width: 160px;
				height: 160px;
				margin-right: 30px;
				-webkit-background-size: cover;
				background-size: cover;
				background-position: center center;
				background-position: center center;
				background-repeat: no-repeat;
			}
			.main-image {
				position: absolute;
				top: 100px;
				width: 430px;
				height: 430px;
				border: 2px solid #bf883b;
				right: 100px;
				border-radius: 50%;
				background: transparent url('<?php echo $image_url ?>') no-repeat center center;
			}
			strong {
				font-weight: 500;
			}
		</style>
	</head>
	<body style="margin: 0; padding: 0;">

	    <div id="canvas-wrapper">

			<?php if ( !has_term( 'torty', 'product_cat', $product_id ) ) : ?>

		        <p class="feature">
		            <span class="icon"><img src="<?php echo get_template_directory_uri() . '/assets/img/share/premium-quality.svg'; ?>"></span>
		            <?php echo __( 'Produkt wysokiej jakości', 'wctheme' ); ?>
		        </p>

		        <p class="feature feature--bottom">
		            <span class="icon"><img src="<?php echo get_template_directory_uri() . '/assets/img/share/van.svg'; ?>"></span>
		            <?php echo __( 'Zamów online z dostawą', 'wctheme' ); ?>
		        </p>

			<?php else: ?>
			
		        <p class="feature feature--top">
		            <span class="icon icon-small"><img src="<?php echo get_template_directory_uri() . '/assets/img/share/empty.svg'; ?>"></span>
		            <?php echo __( 'Średnica:', 'wctheme' ); ?><strong>&nbsp;<?php echo $cake_variant_size; ?></strong>
		        </p>

		        <p class="feature feature--middle">
		            <span class="icon"><img src="<?php echo get_template_directory_uri() . '/assets/img/share/group.svg'; ?>"></span>
		            <?php echo __( 'Idealny dla:', 'wctheme' ); ?><strong>&nbsp;<?php echo $cake_variant_customers; ?></strong>
		        </p>

		        <p class="feature feature--mbottom">
		            <span class="icon"><img src="<?php echo get_template_directory_uri() . '/assets/img/share/van.svg'; ?>"></span>
		            <?php echo __( 'Zamów online z dostawą', 'wctheme' ); ?>
		        </p>

		    <?php endif; ?>

	        <div class="images" >
	            <?php foreach( $gallery as $image ) : ?>
	                <?php if ( $i < 2 ) : ?><div style="background-image: url('<?php echo $image; ?>')" class="gallery-image"></div><?php endif; ?>
	                <?php $i++; ?>
	            <?php endforeach; ?>
	        </div>

	        <div class="main-image"></div>
	    </div>

		<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
		<script src="<?php echo get_template_directory_uri() . '/assets/js/html2canvas.min.js'; ?>"></script>
		<script type="text/javascript">
            jQuery(document).ready(function($){

                html2canvas(document.querySelector("#canvas-wrapper"), {height: 630, width: 1200}).then(canvas => {
                    var img     = new Image();
                    img.src     = canvas.toDataURL(); 

                    $.ajax({
				        type: 'post',
				        dataType: 'json',
				        url: '<?php echo admin_url('admin-ajax.php') ?>',
				        async: false,
				        data: {
				            action: 'wctheme_save_product_social_media_image',
				            product: '<?php echo $_GET['product'] ?>',
				            image: canvas.toDataURL()
				        },
				        success: (response) => {
				        	window.close();
				        }
				    });

                });

            });
        </script>

	</body>
</html>