/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./**/*.php",
    "./assets/**/*.js",
    "!./node_modules/**",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#FF6B35',
          50: '#FFE8E0',
          100: '#FFD8CC',
          200: '#FFB8A3',
          300: '#FF987A',
          400: '#FF8257',
          500: '#FF6B35',
          600: '#FF4500',
          700: '#CC3700',
          800: '#992900',
          900: '#661C00',
        },
        secondary: {
          DEFAULT: '#004E89',
          50: '#E6F1F7',
          100: '#CCE4EF',
          200: '#99C9DF',
          300: '#66AECF',
          400: '#3393BF',
          500: '#004E89',
          600: '#003E6E',
          700: '#002F52',
          800: '#001F37',
          900: '#00101B',
        },
        accent: {
          DEFAULT: '#1AA7EC',
          50: '#E7F6FD',
          100: '#CFEDFB',
          200: '#9FDBF7',
          300: '#6FC9F3',
          400: '#3FB7EF',
          500: '#1AA7EC',
          600: '#1486BD',
          700: '#0F648E',
          800: '#0A435E',
          900: '#05212F',
        },
        dark: {
          DEFAULT: '#1A1A2E',
          50: '#E7E7EA',
          100: '#CFCFD5',
          200: '#9F9FAB',
          300: '#6F6F81',
          400: '#3F3F57',
          500: '#1A1A2E',
          600: '#151525',
          700: '#10101C',
          800: '#0A0A12',
          900: '#050509',
        },
      },
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'sans-serif'],
        display: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      fontSize: {
        'xs': ['0.75rem', { lineHeight: '1rem' }],
        'sm': ['0.875rem', { lineHeight: '1.25rem' }],
        'base': ['1rem', { lineHeight: '1.5rem' }],
        'lg': ['1.125rem', { lineHeight: '1.75rem' }],
        'xl': ['1.25rem', { lineHeight: '1.75rem' }],
        '2xl': ['1.5rem', { lineHeight: '2rem' }],
        '3xl': ['1.875rem', { lineHeight: '2.25rem' }],
        '4xl': ['2.25rem', { lineHeight: '2.5rem' }],
        '5xl': ['3rem', { lineHeight: '1' }],
        '6xl': ['3.75rem', { lineHeight: '1' }],
        '7xl': ['4.5rem', { lineHeight: '1' }],
        '8xl': ['6rem', { lineHeight: '1' }],
        '9xl': ['8rem', { lineHeight: '1' }],
      },
      spacing: {
        '18': '4.5rem',
        '88': '22rem',
        '100': '25rem',
        '112': '28rem',
        '128': '32rem',
      },
      borderRadius: {
        '4xl': '2rem',
      },
      boxShadow: {
        'soft': '0 2px 15px rgba(0, 0, 0, 0.08)',
        'medium': '0 4px 20px rgba(0, 0, 0, 0.12)',
        'strong': '0 10px 40px rgba(0, 0, 0, 0.15)',
        'primary': '0 5px 20px rgba(255, 107, 53, 0.3)',
      },
      backgroundImage: {
        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
        'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
        'gradient-primary': 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
        'gradient-accent': 'linear-gradient(135deg, #FF6B35 0%, #1AA7EC 100%)',
        'gradient-dark': 'linear-gradient(135deg, #1A1A2E 0%, #16213E 100%)',
      },
      animation: {
        'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
        'slide-down': 'slideDown 0.3s ease-out forwards',
        'pulse-glow': 'pulseGlow 2s ease-in-out infinite',
      },
      keyframes: {
        fadeInUp: {
          'from': {
            opacity: '0',
            transform: 'translateY(30px)',
          },
          'to': {
            opacity: '1',
            transform: 'translateY(0)',
          },
        },
        slideDown: {
          'from': {
            opacity: '0',
            maxHeight: '0',
          },
          'to': {
            opacity: '1',
            maxHeight: '500px',
          },
        },
        pulseGlow: {
          '0%, 100%': {
            boxShadow: '0 0 20px rgba(255, 107, 53, 0.3)',
          },
          '50%': {
            boxShadow: '0 0 40px rgba(255, 107, 53, 0.6)',
          },
        },
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}
