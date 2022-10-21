const gulp = require( 'gulp' );
const autoprefixer = require( 'autoprefixer' );
const browserSync = require( 'browser-sync' ).create();
const cache = require( 'gulp-cache' );
const lineec = require( 'gulp-line-ending-corrector' );
const rename = require( 'gulp-rename' );
const sass = require( 'gulp-sass' )( require( 'sass' ) );
const replace = require( 'gulp-replace' );
const zip = require( 'gulp-vinyl-zip' );
const plumber = require( 'gulp-plumber' );
const uglifycss = require( 'gulp-uglifycss' );
const del = require( 'del' );
const readFile = require( 'read-file' );
const rtlcss = require( 'gulp-rtlcss' );
const sourcemaps = require( 'gulp-sourcemaps' );
const postcss = require( 'gulp-postcss' );

const errorHandler = r => notify.onError( '\n\n❌  ==> ERROR: <%= error.message %>\n' )( r );
// Clear cache.
gulp.task( 'clearCache', ( done ) => {
	return cache.clearAll( done );
} );

/******************************************* Build styles *******************************************/
gulp.task( 'mincss', () => {
	return '';
} );

gulp.task( 'clear', function( done ) {
	return cache.clearAll( done );
} );

gulp.task( 'browser-sync', function( done ) {
	browserSync.init( {
		proxy: projectURL,
		open: true,
		injectChanges: true,
	} );
	done();
} );

gulp.task( 'styles', () => {
	return gulp
		.src( ['./src/css/style.scss'] )
		.pipe( plumber( errorHandler ) )
		.pipe( sourcemaps.init() )
		.pipe( sass.sync().on( 'error', sass.logError ) )
		.on( 'error', sass.logError )
		.pipe( postcss( [ autoprefixer() ] ) )
		.pipe( sourcemaps.write( './' ) )
		.pipe( lineec() )
		.pipe( gulp.dest( './build/css/' ) )
		.pipe( browserSync.stream() );
} );

gulp.task( 'watch', gulp.series( 'clear', () => {
	gulp.watch( ['./src/css/style.scss'], gulp.parallel( 'styles' ) );
} ) );

/******************************************* Release *******************************************/

// Clean folder to releases.
gulp.task( 'cleanReleases', () => {
	return del( './releases/**' );
} );

const releasesFiles = [
	'./**',
	'!vendor/**',
	'!node_modules/**',
	'!assets/src/**',
	'!webpack.config.js',
	'!tsconfig.json',
	'!phpcs.xml',
	'!.eslintrc.js',
	'!.eslintignore',
	'!composer.json',
	'!composer.lock',
	'!Gulpfile.js',
	'!package-lock.json',
	'!package.json',
	'!tests/**',
	'!phpunit.xml',
	'!README.md',
    '!src/**',
];

// Copy folder to releases.
gulp.task( 'copyReleases', () => {
	return gulp.src( releasesFiles ).pipe( gulp.dest( './releases/travel-core/' ) );
} );

// Update file Readme
let currentVer = null;

const getCurrentVer = function( force ) {
	if ( currentVer === null || force === true ) {
		const current = readFile.sync( 'travel-core.php', { encoding: 'utf8' } ).match( /Version:\s*(.*)/ );
		currentVer = current ? current[ 1 ] : null;
	}

	return currentVer;
};

gulp.task( 'updateReadme', () => {
	return gulp.src( [ 'readme.txt' ] )
		.pipe( replace( /Stable tag: (.*)/g, 'Stable tag: ' + getCurrentVer( true ) ) )
		.pipe( gulp.dest( './releases/travel-core/', { overwrite: true } ) );
} );

// Create file zip.
gulp.task( 'zipReleases', () => {
	const version = getCurrentVer();

	return gulp
		.src( './releases/travel-core/**', { base: './releases/' } )
		.pipe( zip.dest( './releases/travel-core.' + version + '.zip' ) );
} );

gulp.task(
	'release',
	gulp.series(
		'clearCache',
		//'mincss',
		'cleanReleases',
		'copyReleases',
		'zipReleases',
		( done ) => {
			done();
		}
	)
);

