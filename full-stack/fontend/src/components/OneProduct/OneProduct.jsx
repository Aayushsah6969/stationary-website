import { useState, useEffect } from "react";
import "./OneProduct.css";
import { useLocation } from "react-router-dom";
import useData from "../Data/Data";

const OneProduct = () => {
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [orderDetails, setOrderDetails] = useState({
    customer_name: "",
    product_id: "",
    product_name: "",
    order_quantity: "",
    customer_email: "",
    customer_contact_number: "",
    customer_address: ""
  });

  const [currentData, setCurrentData] = useState(null);
  const [isLoading, setIsLoading] = useState(true);

  const location = useLocation();
  const currentId = location.pathname.split("/")[2];
  console.log("Current ID from URL:", currentId, typeof currentId);

  const allProducts = useData();
  console.log("All Products:", allProducts);

  useEffect(() => {
    if (allProducts.length > 0) {
      allProducts.forEach(product => {
        console.log("Checking product:", product.product_id, typeof product.product_id);
      });

      const foundProduct = allProducts.find((product) => String(product.product_id) === currentId);
      console.log("Found Product:", foundProduct);
      setCurrentData(foundProduct);
      setIsLoading(false);
    }
  }, [allProducts, currentId]);

  const handleBuyNow = () => {
    if (currentData) {
      setOrderDetails({
        ...orderDetails,
        product_id: currentData.product_id,
        product_name: currentData.product_name,
      });
      setIsModalOpen(true);
    }
  };

  const handleCloseModal = () => {
    setIsModalOpen(false);
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    setOrderDetails({
      ...orderDetails,
      [name]: value,
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const response = await fetch('http://192.168.0.183/STATIONARY/backend/place_order.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(orderDetails)
      });
      const data = await response.json();
      if (response.ok) {
        alert('Order placed successfully');
        setIsModalOpen(false);
      } else {
        alert('Failed to place order: ' + data.message);
      }
    } catch (error) {
      console.error('Error:', error);
      alert('Failed to place order');
    }
  };

  if (isLoading) {
    return <div>Loading...</div>;
  }

  if (!currentData) {
    return <div>Product not found</div>;
  }

  return (
    <>
      <section className="text-gray-600 body-font overflow-hidden">
        <div className="container px-5 py-24 mx-auto">
          <div className="lg:w-4/5 mx-auto flex flex-wrap">
            <img
              alt={currentData.product_name}
              className="lg:w-1/2 w-full h-auto object-cover object-center rounded"
              src={currentData.product_image_url}
            />
            <div className="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
              <h1 className="text-gray-900 text-3xl font-medium mb-1">
                {currentData.product_name}
              </h1>
              <p className="leading-relaxed">{currentData.product_description}</p>
              <p className="leading-relaxed">Brand: {currentData.product_brand}</p>
              <p className="leading-relaxed">Category: {currentData.product_category}</p>
              <div className="flex mt-6 items-center pb-5 border-b-2 border-gray-100 mb-5"></div>
              <div className="flex">
                <span className="font-medium text-2xl text-gray-900">
                  Rs. {currentData.product_price}
                </span>
                <button
                  onClick={handleBuyNow}
                  className="flex ml-auto text-white bg-blue-500 border-0 py-2 px-6 focus:outline-none hover:bg-blue-600 rounded"
                >
                  Buy Now
                </button>
              </div>
            </div>
          </div>

          {isModalOpen && (
            <div className="modal-overlay">
              <div className="modal">
                <span className="modal-close" onClick={handleCloseModal}>
                  &times;
                </span>
                <h2>Place Order</h2>
                <form onSubmit={handleSubmit}>
                  <input
                    type="text"
                    placeholder="Your Name"
                    name="customer_name"
                    value={orderDetails.customer_name}
                    onChange={handleChange}
                  />
                  <label htmlFor="Product ID">Product Id:</label>
                  <input
                    type="text"
                    name="product_id"
                    value={orderDetails.product_id}
                    onChange={handleChange}
                    readOnly
                  />
                  <label htmlFor="Product Name">Product Name:</label>
                  <input
                    type="text"
                    name="product_name"
                    value={orderDetails.product_name}
                    onChange={handleChange}
                    readOnly
                  />
                  <input
                    type="number"
                    placeholder="Enter Quantity"
                    name="order_quantity"
                    value={orderDetails.order_quantity}
                    onChange={handleChange}
                  />
                  <input
                    type="email"
                    placeholder="Your email"
                    name="customer_email"
                    value={orderDetails.customer_email}
                    onChange={handleChange}
                  />
                  <input
                    type="text"
                    placeholder="Your Contact Number"
                    name="customer_contact_number"
                    value={orderDetails.customer_contact_number}
                    onChange={handleChange}
                  />
                  <input
                    type="text"
                    placeholder="Your Address"
                    name="customer_address"
                    value={orderDetails.customer_address}
                    onChange={handleChange}
                  />
                  <button type="submit">Place Order</button>
                </form>
              </div>
            </div>
          )}
        </div>
      </section>
    </>
  );
};

export default OneProduct;
