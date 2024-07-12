require('./bootstrap');
// Example of requiring a non-ES6 module
const Livewire = require('../../vendor/livewire/livewire/dist/livewire.js');

// Initialize Livewire
window.Livewire = Livewire;
window.Livewire.start();


// import { Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm'
// Livewire.start()

console.log('Hello, Laravel Mix!');
