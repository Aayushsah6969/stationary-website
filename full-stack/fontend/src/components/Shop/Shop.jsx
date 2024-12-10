import { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import useData from '../Data/Data';

const productsPerPage = 16;

export default function Shop() {
  const [currentPage, setCurrentPage] = useState(1);
  const products = useData();

  const [currentProducts, setCurrentProducts] = useState([]);

  useEffect(() => {
    if (products.length > 0) {
      const indexOfLastProduct = currentPage * productsPerPage;
      const indexOfFirstProduct = indexOfLastProduct - productsPerPage;
      setCurrentProducts(products.slice(indexOfFirstProduct, indexOfLastProduct));
    }
  }, [products, currentPage]);

  const paginate = (pageNumber) => {
    setCurrentPage(pageNumber);
  };

  if (products.length === 0) {
    return <div>Loading...</div>; // Show a loading indicator while fetching data
  }

  return (
    <div className="bg-white">
      <h1 className="text-center mt-2 text-2xl font-bold">Shop the Stationaries</h1>
      <div className="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
        <h2 className="sr-only">Products</h2>
        <div className="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
          {currentProducts.map((product, index) => (
            <Link to={`/shop/${product.product_id}`} key={index} className="group">
              <div className="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                <img
                  src={product.product_image_url}
                  alt={product.product_name}
                  className="h-full w-full object-cover object-center group-hover:opacity-75"
                />
              </div>
              <h3 className="mt-4 text-sm text-gray-700">{product.product_name}</h3>
              <p className="mt-1 text-sm text-gray-500">{product.product_category}</p>

              <p className="mt-1 text-lg font-medium text-gray-900">Rs.{product.product_price}</p>
            </Link>
          ))}
        </div>

        {/* Pagination */}
        <div className="flex items-center mt-8 overflow-auto">
          <hr />
          <button
            onClick={() => setCurrentPage(currentPage - 1)}
            disabled={currentPage === 1}
            className="mr-4 px-4 py-2 bg-blue-500 text-white rounded-md disabled:bg-gray-400"
          >
            Previous
          </button>
          {Array.from({ length: Math.ceil(products.length / productsPerPage) }, (_, i) => i + 1).map((number) => (
            <button
              key={number}
              onClick={() => paginate(number)}
              className={`mx-2 px-4 py-2 rounded-md ${currentPage === number ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800 hover:bg-blue-500 hover:text-white'}`}
            >
              {number}
            </button>
          ))}
          <button
            onClick={() => setCurrentPage(currentPage + 1)}
            disabled={currentPage === Math.ceil(products.length / productsPerPage)}
            className="ml-4 px-4 py-2 bg-blue-500 text-white rounded-md disabled:bg-gray-400"
          >
            Next
          </button>
        </div>
        <hr />
      </div>
    </div>
  );
}
