import { useState, useEffect } from 'react';
import axios from 'axios';

const useData = () => {
  const [data, setData] = useState([]);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get('http://192.168.0.183/STATIONARY/backend/fetch.php');
        console.log("Fetched data:", response.data); // Log the fetched data
        setData(response.data);
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    };

    fetchData();
  }, []);

  return data;
};

export default useData;
