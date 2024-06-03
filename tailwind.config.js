/** @type {import('tailwindcss').Config} */
export default {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
      './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    //   './resources/views/**/*.blade.php',
    ],
    theme: {
      extend: {
        container: {
          center: true, // Horizontally center the container
          padding: {
            DEFAULT: '1rem', // Default padding
            sm: '2rem',      // Padding on small screens
            lg: '4rem',      // Padding on large screens
            xl: '5rem',      // Padding on extra-large screens
          },
        },
        fontSize: {
            '3xl': '1.6rem', // Custom text size
            '4xl': '2.25rem',  // Another custom text size
          },
      },
    },
    plugins: [
      // require('@tailwindcss/forms'),
    ],
  }
