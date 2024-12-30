var gulp       	 = require('gulp'),   // Подключаем Gulp
	less         = require('gulp-less'),  //Подключаем less пакет,
	browserSync  = require('browser-sync'),  // Подключаем Browser Sync
	concat       = require('gulp-concat'), // Подключаем gulp-concat (для конкатенации файлов)
	uglify       = require('gulp-uglifyjs'), // Подключаем gulp-uglifyjs (для сжатия JS)
    cssnano      = require('gulp-cssnano'), // Подключаем пакет для минификации CSS
    rename       = require('gulp-rename'), // Подключаем библиотеку для переименования файлов
    del          = require('del'), // Подключаем библиотеку для удаления файлов и папок
	imagemin     = require('gulp-imagemin'), // Подключаем библиотеку для работы с изображениями
	pngquant     = require('imagemin-pngquant'), // Подключаем библиотеку для работы с png
    cache        = require('gulp-cache'), // Подключаем библиотеку кеширования
	autoprefixer = require('gulp-autoprefixer'); // Подключаем библиотеку для автоматического добавления префиксов

gulp.task('less', function(){ // Создаем таск less
	return gulp.src('src/less/**/*.less')  // Берем источник
		 .pipe(less()) // Преобразуем less в CSS посредством gulp-less
		.pipe(autoprefixer(['last 15 versions', '> 1%', 'ie 8', 'ie 7'], { cascade: true })) // Создаем префиксы
		.pipe(gulp.dest('src/css')) // Выгружаем результата в папку src/css
		.pipe(browserSync.reload({stream: true}))  // Обновляем CSS на странице при изменении
 });

gulp.task('browser-sync', function() { // Создаем таск browser-sync
   browserSync({ // Выполняем browserSync
      proxy: 'http://mysite/www/Shop/src/index.php',  //Название сайта на Open Servere
      notify: false // Отключаем уведомления
   });
});     
    gulp.task('scripts', function() {
 	 	return gulp.src([  // Берем все необходимые библиотеки
 		'src/libs/jquery/dist/jquery.min.js',  // Берем jQuery
 		'src/libs/magnific-popup/dist/jquery.magnific-popup.min.js'  // Берем Magnific Popup
 		])
 		.pipe(concat('libs.min.js'))  // Собираем их в кучу в новом файле libs.min.js
 		.pipe(uglify()) // Сжимаем JS файл
 		.pipe(gulp.dest('src/js')); // Выгружаем в папку src/js
 });

   gulp.task('css-libs',  ['less'], function() {
  	return gulp.src('src/css/libs.css')  // Выбираем файл для минификации
 		.pipe(cssnano())  // Сжимаем
 		.pipe(rename({suffix: '.min'}))  // Добавляем суффикс .min
 		.pipe(gulp.dest('src/css'));  // Выгружаем в папку src/css
 });

      gulp.task('css-main', ['less'], function() {
  	return gulp.src('src/css/main.css') 
 		.pipe(cssnano()) 
 		.pipe(rename({suffix: '.min'}))                
 		.pipe(gulp.dest('src/css')); 
 });
       gulp.task('css-style', ['less'], function() {
  	return gulp.src('src/css/style.css') 
 		.pipe(cssnano()) 
 		.pipe(rename({suffix: '.min'})) 
 		.pipe(gulp.dest('src/css')); 
 });
		gulp.task('css-styles', ['less'], function() {
	return gulp.src('src/css/styles.css')
		.pipe(cssnano())
		.pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest('src/css'));
});
          gulp.task('css-stylesie9',  ['less'], function() {
  	return gulp.src('src/css/stylesie9.css')  // Выбираем файл для минификации
 		.pipe(cssnano())  // Сжимаем
 		.pipe(rename({suffix: '.min'}))  // Добавляем суффикс .min
 		.pipe(gulp.dest('src/css'));  // Выгружаем в папку src/css
 });

 	gulp.task('watch', ['browser-sync', 'css-libs' , 'css-main', 'css-style' , 'css-styles' , 'css-stylesie9', 'scripts'], function() {
	gulp.watch('src/less/**/*.less', ['less']); // Наблюдение за less файлами в папке less
	gulp.watch('src/*.php', browserSync.reload); // Наблюдение за HTML файлами в корне проекта
	gulp.watch('src/functions/*.php', browserSync.reload);
	gulp.watch('src/reg/*.php', browserSync.reload);
	gulp.watch('src/include/*.php', browserSync.reload);
 	gulp.watch('src/js/**/*.js', browserSync.reload);  // Наблюдение за JS файлами в папке js
});

	 gulp.task('clean', function() {
 	return del.sync('dist'); // Удаляем папку dist перед сборкой
	 });

	 gulp.task('img', function() {
	return gulp.src('src/images/**/*') // Берем все изображения из src
		.pipe(cache(imagemin({ // С кешированием
		//.pipe(imagemin({ // Сжимаем изображения без кеширования
			interlaced: true,
			progressive: true,
			svgoPlugins: [{removeViewBox: false}],
			use: [pngquant()]
		})))
		.pipe(gulp.dest('dist/images')); // Выгружаем на продакшен
});

 gulp.task('build', ['clean', 'img', 'less', 'scripts'], function() {

 	var buildCss = gulp.src([  // Переносим библиотеки в продакшен
 		'src/css/main.css',
 		'src/css/main.min.css',
 		'src/css/libs.min.css',
 		'src/css/libs.css',
		'src/css/style.css',
		'src/css/style.min.css',
		'src/css/stylesie9.css',
		'src/css/stylesie9.min.css',
		'src/css/styles.css',
		'src/css/styles.min.css'

 		])
 	.pipe(gulp.dest('dist/css'))

 	var buildFonts = gulp.src('src/fonts/**/*') // Переносим шрифты в продакшен
 	.pipe(gulp.dest('dist/fonts'))

 	var buildJs = gulp.src('src/js/**/*') // Переносим скрипты в продакшен
 	.pipe(gulp.dest('dist/js'))

 	var builddmin = gulp.src('src/dmin/**/*') // Переносим TrackBar в продакшен
 	.pipe(gulp.dest('dist/dmin'))

 	var buildfunctions = gulp.src('src/functions/**/*') // Переносим TrackBar в продакшен
 	.pipe(gulp.dest('dist/functions'))

 	var buildTrackBar = gulp.src('src/TrackBar/**/*') // Переносим TrackBar в продакшен
 	.pipe(gulp.dest('dist/TrackBar'))

 	 	var buildreg = gulp.src('src/reg/**/*') // Переносим TrackBar в продакшен
 	.pipe(gulp.dest('dist/reg'))


 	var buildinclude = gulp.src('src/include/*.php') // Переносим include HTML в продакшен
 	.pipe(gulp.dest('dist/include'))

 	
 	var builduploads_images = gulp.src('src/uploads_images/**/*') // Переносим HTML в продакшен
 	.pipe(gulp.dest('dist/uploads_images'))

 	var buildhtaccess = gulp.src('src/htaccess') // Переносим HTML в продакшен
 	.pipe(gulp.dest('dist'))


 	var buildphp = gulp.src('src/*.php') // Переносим HTML в продакшен
 	.pipe(gulp.dest('dist'));


 });

	  gulp.task('clear', function (callback) {
	  	return cache.clearAll();
	  })

 gulp.task('default', ['watch']);


const  smartgrid = require('smart-grid');

	gulp.task('grid', function() {

		smartgrid('src/less',{
			container:{
				maxWidth: '1170px'
			}
		});
	});