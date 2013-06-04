module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    sass: {
      frontEnd: {
				options: {
					style: 'expanded'
				},
        src: ['assets/css/scss/*.scss', '!assets/css/scss/_*.scss' ],
        dest: 'assets/css/style.css'
      },
      frontEndCompressed: {
        options: { style: 'compressed' },
        src: '<%= sass.frontEnd.src %>',
        dest: 'assets/css/style.min.css'
      },
    },
    watch: {
      sass: {
        files: ['assets/css/scss/*.scss'],
        tasks: ['sass']
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // Default task(s).
  grunt.registerTask('default', ['sass']);


};