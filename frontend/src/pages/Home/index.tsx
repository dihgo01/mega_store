import React, { useState, useEffect } from 'react';
import { MdAddShoppingCart } from 'react-icons/md';

import { ProductList } from './styles';
import { api } from '../../services/api';
import { formatPrice } from '../../util/format';
import { useCart } from '../../hooks/useCart';

interface Product {
  id: string;
  name: string;
  price: number;
}

interface ProductFormatted extends Product {
  priceFormatted: number;
}

interface CartItemsAmount {
  [key: string]: number;
}

const Home = (): JSX.Element => {
  const [products, setProducts] = useState<ProductFormatted[]>([]);
  const { addProduct, cart } = useCart();

  const cartItemsAmount = cart.reduce((sumAmount, product) => {
    const newSumAmount = {...sumAmount};
    newSumAmount[product.id] = product.amount;

    return newSumAmount;
  }, {} as CartItemsAmount)

  useEffect(() => {
    async function loadProducts() {
      const response = await api.get<Product[]>('products');
      
      const data = response.data.map(product => ({
        ...product,
        priceFormatted: product.price
      }))

      setProducts(data);
    }

    loadProducts();
  }, []);

  function handleAddProduct(id: string) {
    addProduct(id);
  }

  return (
    <ProductList>
      {products.map(product => (
        <li key={product.id}>
          <img src="https://rocketseat-cdn.s3-sa-east-1.amazonaws.com/modulo-redux/tenis1.jpg" alt={product.name} />
          <strong>{product.name}</strong>
          <span>{product.priceFormatted}</span>
          <button
            type="button"
            data-testid="add-product-button"
          onClick={() => handleAddProduct(product.id)}
          >
            <div data-testid="cart-product-quantity">
              <MdAddShoppingCart size={16} color="#FFF" />
              {cartItemsAmount[product.id] || 0}
            </div>

            <span>ADICIONAR AO CARRINHO</span>
          </button>
      </li>
      ))}
    </ProductList>
  );
};

export default Home;