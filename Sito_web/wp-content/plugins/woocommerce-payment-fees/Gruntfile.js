module.exports = function (grunt) {
    "use strict";

    // Do grunt-related things in here
    grunt.initConfig({
        pkg : grunt.file.readJSON('package.json'),
        meta : {
            project :   '<%= pkg.name %>',
            version :   '<%= pkg.version %>',
            banner  :   '/*! <%= meta.project %> - v<%= meta.version %> \n' +
                        ' *\n' +
                        ' * <%= pkg.description %>\n' +
                        ' *\n' +
                        ' * Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author.name %> <<%= pkg.author.email %>>\n' +
                        ' * <%= pkg.licenses.type %> Licensed\n' +
                        ' *\n' +
                        ' * Date: <%= grunt.template.today("ddd mmm dd yyyy HH:MM:ss TT Z") %>\n' +
                        ' */\n'
        },

        jshint : {
            options : {
                jshintrc     : '.jshintrc'
            },
            files        : [
                'Gruntfile.js',
                'assets/js/checkout.js'
            ]
        },

        uglify : {
            prod : {
                options : {
                    banner      : '<%= meta.banner %>',
                    compress    : true,
                    mangle      : true
                },
                files : {
                    'assets/js/checkout.min.js' : ['assets/js/checkout.js']
                }
            }
        },

        watch: {
            gruntfile: {
                files: 'Gruntfile.js',
                tasks: ['jshint']
            },
            src: {
                files: ['assets/js/checkout.js'],
                tasks: ['default']
            }
        },

        clean: {
            main: ['release/<%= pkg.version %>']
        },

        copy: {
            // Copy the plugin to a versioned release directory
            main: {
                src:  [
                    '**',
                    '!node_modules/**',
                    '!release/**',
                    '!.git/**',
                    '!Gruntfile.js',
                    '!package.json',
                    '!.gitignore',
                    '!*.sublime-project',
                    '!*.sublime-workspace'
                ],
                dest: 'release/<%= pkg.version %>/'
            }
        },

        compress: {
            main: {
                options: {
                    mode: 'zip',
                    archive: './release/<%= pkg.name %>-<%= pkg.version %>.zip'
                },
                expand: true,
                cwd: 'release/<%= pkg.version %>/',
                src: ['**/*']
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-compress');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask( 'default', [ 'jshint', 'uglify' ] );
    grunt.registerTask( 'dev', [ 'default' ], 'watch' );
    grunt.registerTask( 'build', [ 'default', 'clean', 'copy', 'compress' ] );
};
