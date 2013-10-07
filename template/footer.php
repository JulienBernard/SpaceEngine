	
	<footer id="footer">
		<img src="./img/php.png" alt="PHP" /> <img src="./img/html.png" alt="HTMl" /> <a href="http://foundation.zurb.com/"><img src="./img/foundation.png" alt="Foundation4" /></a> <img src="./img/css.png" alt="CSS" /> <img src="./img/js.png" alt="JS" />
		<p style="margin: 0;">&copy; 2013 SpaceEngine by Julien Bernard.</p>
	</footer>
	
	<!--
		Foundation 4 script.
	-->
	<script>
		document.write('<script src=' +
		('__proto__' in {} ? 'js/vendor/zepto' : 'js/vendor/jquery') +
		'.js><\/script>')
	</script>
	
	<script src="js/foundation.min.js"></script>
	
	<script>
		$(function(){
			$(document).foundation();    
		})
		
		$(document).ready( function () {
			$('.toHome').click(function() {
				$('html,body').animate({scrollTop: $(".home").offset().top}, 'slow');
			});
			$('.toTutorial').click(function() {
				$('html,body').animate({scrollTop: $(".tutorial").offset().top}, 'slow');
			});
			$('.toFollow').click(function() {
				$('html,body').animate({scrollTop: $(".follow").offset().top}, 'slow');
			});
			$('.toTop').click(function() {
				$('html,body').animate({scrollTop: $("#header").offset().top}, 'slow');
			});
			$('.toWhat').click(function() {
				$('html,body').animate({scrollTop: $(".what").offset().top}, 'slow');
			});
			$('.toWhy').click(function() {
				$('html,body').animate({scrollTop: $(".why").offset().top}, 'slow');
			});
			$('.toWho').click(function() {
				$('html,body').animate({scrollTop: $(".who").offset().top}, 'slow');
			});
		})
	</script>	
</body>
</html>