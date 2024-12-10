import { BrowserRouter, Routes, Route } from 'react-router-dom';
import './App.css';
import Navbar from './components/Navbar/Navbar';
import Home from './components/Home/Home';
import Footer from './components/Footer/Footer';
import Shop from './components/Shop/Shop';
import FeaturedProducts from './components/FeaturedProducts/FeaturedProducts';
import TopSeller from './components/TopSeller/TopSeller';
import AboutUs from './components/AboutUs/AboutUs';
import Contact from './components/Contact/Contact';
import SearchResults from './components/SearchResults/SearchResults'; // Import the SearchResults component
import OneProduct from './components/OneProduct/OneProduct';
import Error from './components/Error/Error';

function App() {
  return (
    <BrowserRouter>
      <Navbar />
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/shop" element={<Shop />} />
        <Route path="/shop/:id" element={<OneProduct />} />
        <Route path="/featured-products" element={<FeaturedProducts />} />
        <Route path="/featured-products/:id" element={<OneProduct />} />
        <Route path="/top-seller" element={<TopSeller />} />
        <Route path="/top-seller/:id" element={<OneProduct />} />
        <Route path="/about-us" element={<AboutUs />} />
        <Route path="/contact" element={<Contact />} />
        <Route path="/search/:query" element={<SearchResults />} /> {/* Define the route for the search results page */}
        <Route path="*" element={<Error />} />
      </Routes>
      <Footer />
    </BrowserRouter>
  );
}

export default App;
