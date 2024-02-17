import { defineConfig } from 'vite'
import php from 'vite-plugin-php';
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [php(), vue()],
  build: {
    rollupOptions: {
      output: {
        assetFileNames: `[name].[ext]`,
        chunkFileNames: `[name].js`,
        entryFileNames: `[name].js`,
      }
    }
  }
})
