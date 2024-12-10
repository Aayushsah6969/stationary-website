// import React from 'react';
import { Link } from 'react-router-dom';
import heroImage from '../../assets/heroimage.jpg';
import './Home.css'
import Hero from '../Hero/Hero';
import FeaturedProducts from '../FeaturedProducts/FeaturedProducts';
 
const HomePage = () => {
  return (
    <>
    
 
    <div className="home-page">
     
        <div className="hero-text">
          <h1>Welcome to our Stationary Shop</h1>
          <p>Discover the joy of writing with our premium stationery collection.</p>
          <p>Your one-stop destination for all your stationary needs.</p>
          <Link to="/shop" className="btn btn-primary">Shop Now</Link>
        </div>
        <div className="hero-section">
        <img src={heroImage} alt="Hero" className="hero-image" />
        </div>
     
    </div>
    <div className="hero">
        <Hero/>
    </div>
    <div className="FeaturedProducts">
      <FeaturedProducts/>
    </div>
    
    </>
  );
};

export default HomePage;
