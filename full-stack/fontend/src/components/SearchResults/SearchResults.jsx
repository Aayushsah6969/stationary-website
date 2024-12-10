import { useState, useEffect } from 'react';
import { Link, useParams } from 'react-router-dom';
import './SearchResults.css';

const SearchResults = () => {
  const { query } = useParams();
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchSearchResults = async () => {
      try {
        const response = await fetch(`http://localhost/STATIONARY/backend/search.php?search=${query}`);
        const data = await response.json();
        setProducts(data);
      } catch (error) {
        console.error('Error fetching search results:', error);
      } finally {
        setLoading(false);
      }
    };

    fetchSearchResults();
  }, [query]);

  if (loading) {
    return <div>Loading...</div>;
  }

  return (
    <div className="search-results">
      <h2>Search Results for "{query}"</h2>
      <div className="product-list">
        {products.length > 0 ? (
          products.map(product => (
            <Link key={product.product_id} to={`/shop/${product.product_id}`}>
              <div className="product-card">
                <img src={product.product_image_url} alt={product.product_name} />
                <h3>{product.product_name}</h3>
                <p>{product.product_brand}</p>
                <p>Rs.{product.product_price}</p>
              </div>
            </Link>
          ))
        ) : (
          <p>No products found</p>
        )}
      </div>
    </div>
  );
};

export default SearchResults;
