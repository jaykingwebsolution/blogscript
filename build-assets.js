const fs = require('fs');
const path = require('path');

// Create public/js directory if it doesn't exist
const jsDir = path.join(__dirname, 'public', 'js');
if (!fs.existsSync(jsDir)) {
    fs.mkdirSync(jsDir, { recursive: true });
}

// Copy Alpine.js from node_modules to public/js
const alpineSource = path.join(__dirname, 'node_modules', 'alpinejs', 'dist', 'cdn.min.js');
const alpineDest = path.join(jsDir, 'alpine.min.js');

if (fs.existsSync(alpineSource)) {
    fs.copyFileSync(alpineSource, alpineDest);
    console.log('Alpine.js copied to public/js/alpine.min.js');
} else {
    console.error('Alpine.js source file not found');
}

console.log('Build completed');