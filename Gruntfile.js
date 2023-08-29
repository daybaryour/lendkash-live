!(function() {
    'use strict';
    module.exports = function(grunt) {
        const sass = require('node-sass');
        grunt.initConfig({
            pkg: grunt.file.readJSON('package.json'),
            sass: {
                options: {
                    implementation: sass,
                    sourceMap: true,
                    outputStyle: 'compressed',
                },
                admin: { 
                    files: {
                        'public/css/admin.min.css': 'public/scss/main.scss',
                        'public/css/content.min.css': 'public/scss/content.scss'
                    },
                }
            },
            watch: {
                sass: {
                    files: [
                        'public/scss/*/*.scss','public/scss/**/*.scss','public/scss/***/*.scss',
                        'public/sass/*/*.scss',
                        ['Gruntfile.js']
                    ],
                    tasks: ['sass' ],
                },
            }
        });
        grunt.loadNpmTasks('grunt-sass');
        grunt.loadNpmTasks('grunt-contrib-watch');
        grunt.registerTask('default', ['sass','watch']);
    };
})();
