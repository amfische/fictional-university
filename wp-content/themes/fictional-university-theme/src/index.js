import "./css/style.scss"

// Our modules / classes
import MobileMenu from "./js/modules/MobileMenu"
import HeroSlider from "./js/modules/HeroSlider"
import GoogleMap from "./js/modules/GoogleMap"
import Search from "./js/modules/Search"
import MyNotes from "./js/modules/MyNotes"
import Like from "./js/modules/Like"

// Instantiate a new object using our modules/classes
var mobileMenu = new MobileMenu()
var heroSlider = new HeroSlider()
var googleMap = new GoogleMap()
var search = new Search()
var myNotes = new MyNotes()
var like = new Like()

search.init()
myNotes.init()
like.init()

// Allow new JS and CSS to load in browser without a traditional page refresh
if(module.hot){
  module.hot.accept()
}
