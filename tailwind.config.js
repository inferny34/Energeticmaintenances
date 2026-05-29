/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html', './src/**/*.{vue,js}'],
  theme: {
    extend: {
      colors: {
        'ems-dark':       '#0F1A2E',
        'ems-navy':       '#1B2A4A',
        'ems-surface':    '#162035',
        'ems-dark-alt':   '#111927',
        'ems-footer':     '#070E1A',
        'ems-border':     '#1E2F4A',
        'ems-green':      '#5DBE3A',
        'ems-green-alt':  '#4CAF50',
        'ems-text':       '#EFF0F2',
        'ems-muted':      '#8A96A8',
      },
      fontFamily: {
        display: ['Barlow Condensed', 'sans-serif'],
        body:    ['DM Sans', 'sans-serif'],
      },
      backgroundImage: {
        'dot-grid':           "radial-gradient(circle, #162035 1px, transparent 1px)",
        'glow-green-tr':      "radial-gradient(circle at 85% 20%, rgba(93,190,58,0.07) 0%, transparent 60%)",
        'glow-green-center':  "radial-gradient(circle at 50% 50%, rgba(93,190,58,0.05) 0%, transparent 70%)",
        'glow-green-bottom':  "radial-gradient(ellipse at 50% 100%, rgba(93,190,58,0.06) 0%, transparent 70%)",
        'glow-card-bottom':   "radial-gradient(ellipse at 50% 100%, rgba(93,190,58,0.06) 0%, transparent 70%)",
      },
      backgroundSize: {
        'dot': '28px 28px',
      },
      keyframes: {
        'pulse-dot': {
          '0%, 100%': { transform: 'scale(1)',   opacity: '1'   },
          '50%':       { transform: 'scale(1.7)', opacity: '0.3' },
        },
        'reveal': {
          'from': { opacity: '0', transform: 'translateY(28px)' },
          'to':   { opacity: '1', transform: 'translateY(0)'    },
        },
        'badge-pulse': {
          '0%, 100%': { boxShadow: '0 0 0 0 rgba(93,190,58,0.4)' },
          '50%':       { boxShadow: '0 0 0 6px rgba(93,190,58,0)' },
        },
      },
      animation: {
        'pulse-dot':   'pulse-dot 2s ease-in-out infinite',
        'badge-pulse': 'badge-pulse 2s ease-in-out infinite',
      },
      transitionDelay: {
        '100': '100ms',
        '200': '200ms',
        '300': '300ms',
        '400': '400ms',
      }
    }
  },
  plugins: []
}
