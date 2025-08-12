import "./bootstrap";
import "./swiper";
import "../css/swiper.css";
import Alpine from "alpinejs";

console.log("App.js loaded");

window.Alpine = Alpine;

Alpine.start();

console.log("Alpine started");
