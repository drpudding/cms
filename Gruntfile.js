// Gruntfile
// task:
module.exports = function(grunt) {

  //Initializing the configuration object
    grunt.initConfig({

      // LESS TASK config
    less: {
        development: {
            options: {
              compress: true, // minifying the result
            },
            files: {
              
              "./public/assets/css/frontend.css":"./app/assets/css/frontend.less",  // compile frontend.less -> frontend.css
              "./public/assets/css/backend.css":"./app/assets/css/backend.less",    // compile backend.less -> backend.css
              // these remain separate
              "./public/assets/css/colorbox.css":"./app/assets/css/colorbox.css",
              "./public/assets/css/jquery.dataTables.css":"./app/assets/components/bower/datatables/media/css/jquery.dataTables.css",
              "./public/assets/css/datatable.css":"./app/assets/components/bower/datatables-bootstrap3/BS3/assets/css/datatables.css",
              //"./public/assets/css/wysihtml5/prettify.css":"./app/assets/css/wysihtml5/prettify.css",
              // "./public/assets/css/wysihtml5/bootstrap-wysihtml5.css":"./app/assets/css/wysihtml5/bootstrap-wysihtml5.css",
              "./public/assets/css/bootstrap3-wysihtml5.css":"./app/assets/components/bower/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.css", 
            }
        }
    },

    // CONCAT TASK config
    // Note: if you concat minified versions, skip uglify task, below
    concat: {
      options: {
        separator: ';',
      },

      // js_frontend Target; this task is concat:js_frontend 
      js_frontend: {
        src: [
          './app/assets/components/bower/jquery/jquery.js',
          './app/assets/components/bower/bootstrap/dist/js/bootstrap.js',
          './app/assets/js/frontend.js'
        ],
        dest: './public/assets/js/frontend.js', // compile frontend.js
      },

      // js_backend Target; his task is concat:js_backend 
      js_backend: {
        src: [
        //'./app/assets/components/bower/wysihtml5/dist/wysihtml5-0.3.0.js',
          './app/assets/components/bower/jquery/jquery.js',
          './app/assets/components/bower/bootstrap/dist/js/bootstrap.js',
          "./app/assets/components/bower/datatables/media/js/jquery.dataTables.js",
          "./app/assets/components/bower/datatables-bootstrap3/BS3/assets/js/datatables.js",
          './app/assets/js/datatables.columnFilter.js',
          './app/assets/js/datatables.filterClear.js',
          
          //'./app/assets/js/wysihtml5/wysihtml5-0.3.0.js',
          //'./app/assets/js/wysihtml5/bootstrap-wysihtml5.js',
        //'./app/assets/components/bower/handlebars/handlebars.runtime.min.js',
          './app/assets/components/bower/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.all.min.js',
          './app/assets/js/jquery.colorbox.js',
          //'./app/assets/js/prettify.js',
          './app/assets/js/backend.js'
          //'./app/assets/js/datatables.fnReloadAjax.js'
          //'./app/assets/js/dataTables.columnFilter-0.js'
        ],
        dest: './public/assets/js/backend.js', // compile frontend.js
      },
    },

    // UGLIFY TASK config (minify)
    uglify: {
      options: {
        mangle: false // leave function & variable names unchanged
      },

      // frontend Target; This task is uglify:frontend 
      frontend: {
        files: {
          './public/assets/js/frontend.js': './public/assets/js/frontend.js',
        }
      },

      // backend Target; This task is uglify:backend 
      backend: {
        files: {
          './public/assets/js/backend.js': './public/assets/js/backend.js',
        }
      },
    },

    // MINIMIZE IMAGES TASK config
    imagemin: {
      static: {  // the target
        options: { // options
          optimizationLevel: 3
        },
        files: {
          // 'dist/img.png': 'src/img.png', // 'destination': 'source'
          // 'dist/img.jpg': 'src/img.jpg',
          // 'dist/img.gif': 'src/img.gif'
        }
      },
      dynamic: { // Another target
        files: [{
          expand: true,                 // enable dynamic expansion
          cwd: './app/assets/img/',     // cwd is 'current working directory'
          src: ['**/*.{png,jpg,gif}'],  // patterns to match
          dest: './public/assets/img/'  // destination
        }]
      }
    },

    // WATCH
    watch: {

        js_frontend: {
          files: [
            // watch for updates
            './app/assets/components/bower/jquery/jquery.js',
            './app/assets/components/bower/bootstrap/dist/js/bootstrap.js',
            './app/assets/js/frontend.js'
            ],
          tasks: ['concat:js_frontend','uglify:frontend'], // run these tasks
          options: {
            livereload: true // reload in browser
          }
        },

        js_backend: {
          files: [
            // watch for updates
            './app/assets/components/bower/jquery/jquery.js',
            './app/assets/components/bower/bootstrap/dist/js/bootstrap.js',
            './app/assets/js/backend.js'
          ],
          tasks: ['concat:js_backend','uglify:backend'], // run these tasks
          options: {
            livereload: true // reload in browser
          }
        },

        less: {
          files: ['./app/assets/css/*.less'], // watch for updates
          tasks: ['less'], // run these tasks
          options: {
            livereload: true // reload in browser
          }
        },

        imagemin: {
          files: ['./app/assets/img/'], // watch for updates
          tasks: ['imagemin'], // run these tasks
          options: {
            livereload: true // reload in browser
          }
        }
      }
    });

  // Plugin loading
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-imagemin');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // Task definition
  grunt.registerTask('default', ['less', 'concat', 'uglify', 'watch']);//

};