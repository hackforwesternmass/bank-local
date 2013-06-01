module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    sass: {
      options: { style: 'compressed' },
      dev: {
        options: {
          style: 'expanded',
          lineNumbers: true
        },
        files: { 'assets/css/style.css': 'assets/css/style.scss' }
      }
    },
    watch: {
      sass: {
        files: ['assets/css/style.scss', 'assets/css/scss/**/*.scss'],
        tasks: ['sass']
      }
    }
  });

  // Load the plugin that provides the "uglify" task.
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // Default task(s).
  grunt.registerTask('default', ['sass']);
};
