import { Link } from "react-router-dom";
import useData from "../Data/Data";

export default function FeaturedProducts() {
  const products = useData();
  const firstFourProducts = products.slice(0, 6);

  return (
    <div className="bg-white">
      <div className="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
        <h2 className="text-2xl font-bold tracking-tight text-gray-900">Customers also purchased</h2>
        <div className="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
          {firstFourProducts.map((product, index) => (
            <Link to={`/shop/${product.product_id}`} key={index} className="group relative">
              <div className="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                <img
                  src={product.product_image_url}
                  alt={product.product_name}
                  className="h-full w-full object-cover object-center lg:h-full lg:w-full"
                />
              </div>
              <div className="mt-4 flex justify-between">
                <div>
                  <h3 className="text-sm text-gray-700">
                    <span aria-hidden="true" className="absolute inset-0" />
                    {product.product_name}
                  </h3>
                  <p className="mt-1 text-sm text-gray-500">{product.product_category}</p>
                </div>
                <p className="text-sm font-medium text-gray-900">Rs.{product.product_price}</p>
              </div>
            </Link>
          ))}
        </div>
      </div>
    </div>
  );
}
