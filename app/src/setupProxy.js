const proxy = require('http-proxy-middleware');
module.exports = function(app) {
<<<<<<< HEAD
    app.use(proxy('/apis', {
        logLevel: 'debug',
        target: "https://bootcamp-coders.cnm.edu/~fgallegos59/foodies/php/public_html/",
        changeOrigin: true,
        secure: true, }));
};
=======
	app.use(proxy('/apis', {
		logLevel: 'debug',
		target: "https://bootcamp-coders.cnm.edu/~cnewsome2/foodies/php/public_html/",
		changeOrigin: true,
		secure: true, }));
};
>>>>>>> c72bb3caac813b828615002d5e31460cf9a0e46d
