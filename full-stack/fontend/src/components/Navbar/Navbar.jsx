import { useState, useEffect } from 'react';
import { Link, useLocation, useNavigate } from 'react-router-dom';
import nprogress from 'nprogress';
import 'nprogress/nprogress.css';
import logo from '../../assets/logo.svg';
import './Navbar.css';

const Navbar = () => {
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [searchQuery, setSearchQuery] = useState('');
  const location = useLocation();
  const navigate = useNavigate();

  const toggleSidebar = () => {
    setSidebarOpen(!sidebarOpen);
  };

  const handleSearchChange = (e) => {
    setSearchQuery(e.target.value);
  };

  const handleSearchSubmit = (e) => {
    e.preventDefault();
    navigate(`/search/${searchQuery}`);
  };

  // Configure NProgress
  nprogress.configure({ showSpinner: false });

  useEffect(() => {
    const handleRouteChangeStart = () => {
      nprogress.start();
    };

    const handleRouteChangeEnd = () => {
      nprogress.done();
    };

    // Listen to route changes
    handleRouteChangeStart(); // Start progress bar on initial load
    handleRouteChangeEnd(); // End progress bar on initial load

    // Clean up the listeners
    return () => {
      handleRouteChangeEnd();
    };
  }, [location]);

  return (
    <nav className="navbar">
      <div className="logo-div">
        <Link to="/" className="logo">
          <img src={logo} alt="Stationary Shop Logo" />
        </Link>
      </div>

      <ul className="nav-links">
        <li><Link to="/">Home</Link></li>
        <li><Link to="/shop">Shop</Link></li>
        <li><Link to="/top-seller">Top Seller</Link></li>
        <li><Link to="/about-us">About Us</Link></li>
        <li><a href="https://github.com/Aayushsah6969" target="_blank" rel="noopener noreferrer">Developers</a></li>
        <li><Link to="/contact">Contact</Link></li>
      </ul>


      <div className="buttons">
        <button className='SignIn'>Sign In</button>
        <button className='LogIn'>LogIn</button>
        <button className='Log Out'>Log Out</button>
      </div>

      <div className="search-bar">
        <form onSubmit={handleSearchSubmit}>
          <input
            type="search"
            placeholder="Search products..."
            value={searchQuery}
            onChange={handleSearchChange}
          />
          
        </form>
      </div>

      {/* Burger Menu */}
      <div className={`burger-menu ${sidebarOpen ? 'open' : ''}`} onClick={toggleSidebar}>
        <div className="line line-1"></div>
        <div className="line line-2"></div>
        <div className="line line-3"></div>
      </div>

      {/* Sidebar */}
      <div className={`sidebar ${sidebarOpen ? 'open' : ''}`}>
        <ul>
          <li><Link to="/">Home</Link></li>
          <li><Link to="/shop">Shop</Link></li>
          <li><Link to="/featured-products">Featured Products</Link></li>
          <li><Link to="/top-seller">Top Seller</Link></li>
          <li><Link to="/about-us">About Us</Link></li>
          <li><Link to="/contact">Contact</Link></li>
        </ul>
      </div>
    </nav>
  );
};

export default Navbar;
