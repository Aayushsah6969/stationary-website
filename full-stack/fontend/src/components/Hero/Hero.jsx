// import React from 'react'
import './Hero.css';
import { Link } from 'react-router-dom';


const Hero = () => {
  return (
    <>
   <section className="hero-section">
      <div className="container">
        <div className="image-container">
          <img className="hero-image" alt="hero" src="https://media.istockphoto.com/id/1318679262/video/child-with-school-stationery-boy-choosing-stationery-in-the-submarket.jpg?s=640x640&k=20&c=lUTsgEOtP49XVGK-ro9qwC6UIDNhDcBnJzpcbXuXt_U=" />
        </div>
        <div className="text-container">
          <h1 className="hero-title">Discover artisanal delights before they become mainstream.</h1>
          <p className="hero-description">Indulge in a sensory journey through artisanal craftsmanship, where each product tells a unique story of passion and creativity.  </p>
          <div className="button-container">
          <Link to="/top-seller"  className="primary-button">Top Seller</Link>
            <Link to="/shop"   className="secondary-button">Shop Now</Link>
          </div>
        </div>
      </div>
    </section>
    </>
  )
}

export default Hero