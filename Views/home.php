<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Empresa Odontológica &amp; Bootstrap Template</title>
	<link rel="icon" type="image/png" href="<?= media() ?>/clinica/img/logo1 (2).png">
	<link rel="stylesheet" href="<?= media() ?>/clinica/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

	<link rel="stylesheet" href="<?= media() ?>/clinica/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= media() ?>/clinica/css/style.css">

	<link href="http://fonts.googleapis.com/css?family=Open+Sans:600italic,400,800,700,300" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=BenchNine:300,400,700" rel="stylesheet" type="text/css">
	<script src="<?= media() ?>/clinica/js/modernizr.js"></script>
	<!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->

</head>

<body>

	<!-- ====================================================
	header section -->
	<header class="top-header">
		<div class="container">
			<div class="row">
				<div class="col-xs-5 header-logo">
					<br>
					<img src="<?= media() ?>/clinica/img/logo.png" alt="Logo de la clínica" class="img-responsive logo" width="200" height="auto">
				</div>

				<div class="col-md-7">
					<nav class="navbar navbar-default">
						<div class="container-fluid nav-bar">
							<!-- Brand and toggle get grouped for better mobile display -->
							<div class="navbar-header">
								<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
							</div>

							<!-- Collect the nav links, forms, and other content for toggling -->
							<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

								<ul class="nav navbar-nav navbar-right">
									<li><a class="menu active" href="#home">Inicio</a></li>
									<li><a class="menu" href="#service">Servicios</a></li>
									<li><a href="#" id="reservasMenu" data-toggle="modal" data-target="#reservasModal">Reservas</a></li>
									<li><a class="menu" href="#contact">Contacto</a></li>
									<li><a href="<?= base_url() ?>/login">Inicio de Sesión</a></li>
								</ul>
							</div><!-- /navbar-collapse -->
						</div><!-- / .container-fluid -->
					</nav>
				</div>
			</div>
		</div>
	</header> <!-- end of header area -->

	<section class="slider" id="home">
		<div class="container-fluid">
			<div class="row">
				<div id="carouselHacked" class="carousel slide carousel-fade" data-ride="carousel">
					<div class="header-backup"></div>
					<!-- Wrapper for slides -->
					<div class="carousel-inner" role="listbox">
						<div class="item active">
							<img src="<?= media() ?>/clinica/img/slide-one.jpg" alt="" width="1400" height="900">
							<div class="carousel-caption">
								<h1>Empresa Odontológica</h1>
								<p>Calsado</p>

							</div>
						</div>
						<div class="item">
							<img src="<?= media() ?>/clinica/img/slide-two.jpg" alt="">
							<div class="carousel-caption">
								<h1>Empresa Odontológica </h1>
								<p>Limpieza Dental </p>

							</div>
						</div>
						<div class="item">
							<img src="<?= media() ?>/clinica/img/slide-three.jpeg" alt="" width="1400" height="900">
							<div class="carousel-caption">
								<h1>Empresa Odontológica </h1>
								<p>Tratamiento de Conducto (Endodoncia) </p>

							</div>
						</div>
						<div class="item">
							<img src="<?= media() ?>/clinica/img/slide-four.jpg" alt="">
							<div class="carousel-caption">
								<h1>Empresa Odontológica </h1>
								<p>Implantes Dentales </p>

							</div>
						</div>
					</div>
					<!-- Controls -->
					<a class="left carousel-control" href="#carouselHacked" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#carouselHacked" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
			</div>
		</div>
	</section><!-- end of slider section -->

	<!-- about section -->
	<section class="about text-center" id="about">
		<div class="container">
			<div class="row">
				<h2>Nosotros</h2>
				<h4>Nos dedicamos a cuidar tu sonrisa y tu salud bucal con pasión y compromiso.
					Nuestro equipo de profesionales altamente capacitados y especializados
					está aquí para ofrecerte la mejor atención odontológica en un ambiente
					acogedor y confortable. Con tecnología de vanguardia y un enfoque humano,
					trabajamos para asegurar que cada visita sea una experiencia positiva y
					que tu sonrisa brille con confianza.</h4>
				<div class="col-md-4 col-sm-6">
					<div class="single-about-detail clearfix">
						<div class="about-img">
							<img class="img-responsive" src="<?= media() ?>/clinica/img/item1.jpg" alt="">
						</div>
						<div class="about-details">
							<div class="pentagon-text">
								<h1>L</h1>
							</div>
							<h3>Limpieza Dental</h3>
							<p>En nuestra Empresa Odontológica, ofrecemos servicios de limpieza
								profesional diseñados para eliminar placa y sarro, dejando
								tus dientes limpios, brillantes y saludables. Reserva hoy y
								experimenta una sonrisa más fresca y radiante.</p>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<div class="single-about-detail">
						<div class="about-img">
							<img class="img-responsive" src="<?= media() ?>/clinica/img/item2.jpg" alt="">
						</div>
						<div class="about-details">
							<div class="pentagon-text">
								<h1>ED</h1>
							</div>

							<h3>Extracciones Dentales</h3>
							<p>Realizamos extracciones dentales con técnicas avanzadas y
								cuidado personalizado. Nuestro equipo garantiza procedimientos
								seguros y efectivos para aliviar el dolor y restaurar
								tu salud bucal. Confía en nosotros para cuidar de tu
								sonrisa con profesionalismo y atención integral.</p>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<div class="single-about-detail">
						<div class="about-img">
							<img class="img-responsive" src="<?= media() ?>/clinica/img/item3.jpg" alt="">
						</div>
						<div class="about-details">
							<div class="pentagon-text">
								<h1>I</h1>
							</div>
							<h3> Implantes Dentales</h3>
							<p>Nuestros implantes dentales ofrecen soluciones duraderas y
								estéticamente naturales para restaurar tu sonrisa. Con tecnología
								avanzada y atención personalizada, aseguramos resultados precisos
								y confort durante todo el proceso. Recupera la funcionalidad y
								confianza en tu sonrisa con nuestro equipo especializado en
								implantes dentales.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section><!-- end of about section -->


	<!-- service section starts here -->
	<section class="service text-center" id="service">
		<div class="container">
			<div class="row">
				<h2>Nuestros servicios</h2>
				<h4>En nuestra Empresa Odontológica, ofrecemos una amplia gama de servicios
					diseñados para cuidar y mejorar tu salud dental. Desde limpiezas y
					tratamientos de endodoncia hasta implantes y estética dental,
					nuestro equipo dedicado está aquí para proporcionarte cuidado de
					calidad con tecnología avanzada y atención personalizada.
					Tu sonrisa es nuestra prioridad.</h4>
				<div class="col-md-3 col-sm-6">
					<div class="single-service">
						<div class="single-service-img">
							<div class="service-img">
								<!--<img class="heart img-responsive" src="<?= media() ?>/clinica/img/service1.jpg" alt="">-->
								<br>
								<h3> Limpieza Dental</h3>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="single-service">
						<div class="single-service-img">
							<div class="service-img">
								<!--<img class="brain img-responsive" src="<?= media() ?>/clinica/img/service2.png" alt="">-->
								<br>
								<h3>Exámenes y Diagnósticos</h3>
							</div>
						</div>

					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="single-service">
						<div class="single-service-img">
							<div class="service-img">
								<!--<img class="knee img-responsive" src="<?= media() ?>/clinica/img/service3.png" alt="">-->
								<br>
								<h3>Extracciones Dentales</h3>
							</div>
						</div>

					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="single-service">
						<div class="single-service-img">
							<div class="service-img">
								<!--<img class="bone img-responsive" src="<?= media() ?>/clinica/img/service4.png" alt="">-->
								<br>
								<h3>Coronas y Puentes</h3>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div><br><br><br><br><br>
	</section><!-- end of service section -->



	<!-- Modal -->
	<div class="modal" id="reservasModal" tabindex="-1" role="dialog" aria-labelledby="reservasModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<!-- Título principal -->
					<h3 class="modal-title text-center" id="reservasModalLabel" style="font-size: 50px; font-weight: bold;">Empresa Odontológica</h3>
					<!-- Botón para cerrar el modal -->
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<!-- Subtítulo -->
					<h5 class="text-center" style="font-size: 35px; font-weight: bold;">Reservas</h5>
					<div id="reservas" class="content">
						<!-- Contenido del chatbot u otro contenido del modal -->
						<div id="chatbot">
							<p id="botResponse" style="font-size: 20px;"></p>
							<div id="chatContainer" class="chat-container">
								<!-- Mensajes del chatbot y del usuario -->
								<div class="message user">

								</div>
								<div class="message bot">
									Soy tu asistente virtual, ¿en qué te puedo ayudar?
								</div>
								<!-- Burbujas de respuesta -->
								<div class="typing-indicator">
									<span></span>
									<span></span>
									<span></span>
								</div>
							</div>
							<!-- Campo de entrada y botón de envío -->
							<input type="text" id="userInput" placeholder="Escribe tu mensaje aquí..." style="font-size: 20px;">
							<button id="sendButton" style="font-size: 20px;">
								<i class="fas fa-paper-plane"></i>
							</button>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<style>
		.chat-container {
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			height: 300px;
			/* Ajusta la altura según tu diseño */
			overflow-y: auto;
			/* Para hacer scroll en el contenedor */
		}

		.message {
			border-radius: 10px;
			padding: 8px;
			margin-bottom: 8px;
			max-width: 70%;
			word-wrap: break-word;
		}

		.message.user {
			background-color: #e9ebee;
			color: #333;
			align-self: flex-start;
		}

		.message.bot {
			background-color: #007bff;
			color: #ffffff;
			align-self: flex-end;
		}

		.typing-indicator {
			display: none;
			/* Por defecto oculto */
			align-self: flex-end;
		}

		.typing-indicator span {
			display: inline-block;
			width: 8px;
			height: 8px;
			border-radius: 50%;
			background-color: #007bff;
			margin-right: 4px;
			animation: typingAnimation 1s infinite;
		}

		@keyframes typingAnimation {

			0%,
			50%,
			100% {
				opacity: 1;
			}

			25% {
				opacity: 0.5;
			}
		}


		.chat-container {
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			height: 300px;
			/* Ajusta la altura según tu diseño */
			overflow-y: auto;
			/* Para hacer scroll en el contenedor */
		}

		.message {
			border-radius: 10px;
			padding: 8px;
			margin-bottom: 8px;
			max-width: 70%;
			word-wrap: break-word;
			font-size: 24px;
			/* Tamaño de letra para todos los mensajes */
		}

		.message.user {
			background-color: #e9ebee;
			color: #333;
			align-self: flex-start;
		}

		.message.bot {
			background-color: #007bff;
			color: #ffffff;
			align-self: flex-end;
		}

		.typing-indicator {
			display: none;
			/* Por defecto oculto */
			align-self: flex-end;
		}

		.typing-indicator span {
			display: inline-block;
			width: 8px;
			height: 8px;
			border-radius: 50%;
			background-color: #007bff;
			margin-right: 4px;
			animation: typingAnimation 1s infinite;
		}

		@keyframes typingAnimation {

			0%,
			50%,
			100% {
				opacity: 1;
			}

			25% {
				opacity: 0.5;
			}
		}

		.chat-container {
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			height: 300px;
			/* Ajusta la altura según tu diseño */
			overflow-y: auto;
			/* Para hacer scroll en el contenedor */
		}

		.message {
			border-radius: 10px;
			padding: 8px;
			margin-bottom: 8px;
			max-width: 70%;
			word-wrap: break-word;
			font-size: 24px;
			/* Tamaño de letra para todos los mensajes */
		}

		.message.user {
			background-color: #e9ebee;
			color: #333;
			align-self: flex-start;
		}

		.message.bot {
			background-color: #007bff;
			color: #ffffff;
			align-self: flex-end;
		}

		.typing-indicator {
			display: none;
			/* Por defecto oculto */
			align-self: flex-end;
		}

		.typing-indicator span {
			display: inline-block;
			width: 8px;
			height: 8px;
			border-radius: 50%;
			background-color: #007bff;
			margin-right: 4px;
			animation: typingAnimation 1s infinite;
		}

		@keyframes typingAnimation {

			0%,
			50%,
			100% {
				opacity: 1;
			}

			25% {
				opacity: 0.5;
			}
		}

		/* Estilos para el input text */
		#userInput {
			font-size: 20px;
			/* Tamaño de letra */
			padding: 8px;
			/* Espaciado interno */
			border: 1px solid #007bff;
			/* Borde */
			border-radius: 5px;
			/* Borde redondeado */
			width: calc(100% - 90px);
			/* Ancho del input */
			margin-right: 8px;
			/* Margen derecho */
			box-sizing: border-box;
			/* Para incluir el padding y border en el ancho total */
		}

		/* Estilo para el botón de enviar */
		#sendButton {
			font-size: 20px;
			/* Tamaño de letra */
			padding: 10px 15px;
			/* Espaciado interno (arriba y abajo, izquierda y derecha) */
			border: none;
			/* Sin borde */
			border-radius: 5px;
			/* Borde redondeado */
			background-color: #007bff;
			/* Color de fondo */
			color: #ffffff;
			/* Color de texto */
			cursor: pointer;
			/* Cambia el cursor al pasar sobre el botón */
		}

		/* Estilo para el botón de enviar al pasar el cursor */
		#sendButton:hover {
			background-color: #0056b3;
			/* Color de fondo al pasar el cursor */
		}
	</style>













	<!-- map section -->
	<div class="api-map" id="contact">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 map" id="map"></div>
			</div>
		</div>
	</div><!-- end of map section -->

	<!-- contact section starts here -->
	<section class="contact">
		<div class="container">
			<div class="row">
				<div class="contact-caption clearfix">
					<div class="contact-heading text-center">
						<h2>Contactos</h2>
					</div>
					<div class="col-md-5 contact-info text-left">
						<h3>Informacion</h3>
						<div class="info-detail">
							<ul>
								<li><i class="fa fa-calendar"></i><span>Monday - Friday:</span> 9:30 AM to 6:30 PM</li>
							</ul>
							<ul>
								<li><i class="fa fa-map-marker"></i><span>Address:</span> 123 Some Street , London, UK, CP 123</li>
							</ul>
							<ul>
								<li><i class="fa fa-phone"></i><span>Phone:</span> (032) 987-1235</li>
							</ul>
							<ul>
								<li><i class="fa fa-fax"></i><span>Fax:</span> (123) 984-1234</li>
							</ul>
							<ul>
								<li><i class="fa fa-envelope"></i><span>Email:</span> info@doctor.com</li>
							</ul>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section><!-- end of contact section -->

	<!-- footer starts here -->
	<footer class="footer clearfix">
		<div class="container">
			<div class="row">
				<div class="col-xs-6 footer-para">
					<p>&copy;Mostafizur All right reserved</p>
				</div>
				<div class="col-xs-6 text-right">
					<a href=""><i class="fa fa-facebook"></i></a>
					<a href=""><i class="fa fa-twitter"></i></a>
					<a href=""><i class="fa fa-skype"></i></a>
				</div>
			</div>
		</div>
	</footer>

	<!-- script tags
	============================================================= -->
	<script src="<?= media() ?>/clinica/js/scripts.js"></script>
	<script src="<?= media() ?>/clinica/js/jquery-2.1.1.js"></script>
	<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
	<script src="<?= media() ?>/clinica/js/gmaps.js"></script>
	<script src="<?= media() ?>/clinica/js/smoothscroll.js"></script>
	<script src="<?= media() ?>/clinica/js/bootstrap.min.js"></script>
	<script src="<?= media() ?>/clinica/js/custom.js"></script>
</body>

</html>

<script>
	var base_url = 'http://localhost/clinica_dental';
	$(document).ready(function() {
		// Verificar si el elemento existe antes de intentar acceder a offset
		var $target = $('#someElementId');
		if ($target.length > 0) {
			var offset = $target.offset();
			// Usar offset en tu lógica aquí
			console.log('Offset:', offset);
		} else {
			console.warn('El elemento con ID "someElementId" no se encontró en el DOM.');
		}
	});


	document.addEventListener('DOMContentLoaded', function() {
		let sendButton = document.getElementById('sendButton');
		let userInput = document.getElementById('userInput');
		let chatContainer = document.getElementById('chatContainer');

		if (sendButton && userInput && chatContainer) {
			sendButton.addEventListener('click', function() {
				let userInputValue = userInput.value;

				// Agregar mensaje del usuario al contenedor de chat
				let userMessageElement = document.createElement('div');
				userMessageElement.classList.add('message', 'user');
				userMessageElement.textContent = userInputValue;
				chatContainer.appendChild(userMessageElement);

				let request = (window.XMLHttpRequest) ?
					new XMLHttpRequest() :
					new ActiveXObject('Microsoft.XMLHTTP');
				let ajaxUrl = base_url + '/Home/setPrueba/';
				let formData = new FormData();
				formData.append('userInput', userInputValue);
				request.open("POST", ajaxUrl, true);
				request.send(formData);
				request.onreadystatechange = function() {
					if (request.readyState != 4) return;
					if (request.status == 200) {
						console.log(request.responseText); // Verifica el contenido de la respuesta
						try {
							let objData = JSON.parse(request.responseText);
							if (objData.status) {
								// Mostrar burbujas de respuesta antes de simular respuesta del bot
								showTypingIndicator();

								// Simular respuesta del bot después de un tiempo (ejemplo: 1.5 segundos)
								setTimeout(function() {
									// Ocultar burbujas de respuesta después de mostrar la respuesta del bot
									hideTypingIndicator();

									// Agregar respuesta del chatbot al contenedor de chat
									let botMessageElement = document.createElement('div');
									botMessageElement.classList.add('message', 'bot');
									botMessageElement.textContent = objData.msg;
									chatContainer.appendChild(botMessageElement);

									// Hacer scroll hacia abajo para mostrar el último mensaje
									chatContainer.scrollTop = chatContainer.scrollHeight;
								}, 1500); // Tiempo simulado de respuesta (1.5 segundos)

							} else {
								console.error("Error: ", objData.msg);
							}
						} catch (e) {
							console.error("Error al analizar JSON: ", e);
						}
					}
				};

				// Limpiar el campo de entrada después de enviar el mensaje
				userInput.value = '';
			});
		} else {
			console.error('Elementos no encontrados en el DOM');
		}

		// Función para mostrar las burbujas de respuesta
		function showTypingIndicator() {
			let typingIndicator = document.createElement('div');
			typingIndicator.classList.add('typing-indicator');
			typingIndicator.innerHTML = `
            <span></span>
            <span></span>
            <span></span>
        `;
			chatContainer.appendChild(typingIndicator);
		}

		// Función para ocultar las burbujas de respuesta
		function hideTypingIndicator() {
			let typingIndicator = document.querySelector('.typing-indicator');
			if (typingIndicator) {
				typingIndicator.remove();
			}
		}
	});
</script>