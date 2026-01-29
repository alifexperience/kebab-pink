    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fb;
            min-height: 100vh;
        }

        .content {
            padding: 20px;
        }

        /* ===== CONTENT ===== */
        .pos-container {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 25px;
            margin-top: 10px;
        }

        /* Header Page */
        .page-header {
            background: white;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border-left: 5px solid #ff4d6d;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .page-header h1 {
            font-size: 28px;
            color: #2d3748;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-header h1 i {
            color: #ff4d6d;
        }

        .transaction-info {
            display: flex;
            align-items: center;
            gap: 15px;
            color: #666;
            font-size: 14px;
            background: #f8f9fa;
            padding: 10px 15px;
            border-radius: 10px;
        }

        .transaction-info i {
            color: #ff4d6d;
        }

        .menu-section {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .section-header h3 {
            font-size: 20px;
            color: #2d3748;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-header h3 i {
            color: #ff4d6d;
        }

        .menu-count {
            background: #ff4d6d;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 20px;
            max-height: 600px;
            
            padding-right: 10px;
        }

        .menu-grid::-webkit-scrollbar {
            width: 6px;
        }

        .menu-grid::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .menu-grid::-webkit-scrollbar-thumb {
            background: #ff4d6d;
            border-radius: 10px;
        }

        .menu-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid #f0f0f0;
            position: relative;
            overflow: hidden;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            border-color: #ff4d6d;
            box-shadow: 0 10px 25px rgba(255, 77, 109, 0.15);
        }

        .menu-icon {
            font-size: 36px;
            margin-bottom: 12px;
            color: #ff4d6d;
            height: 70px;
            width: 70px;
            background: rgba(255, 77, 109, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px auto;
        }

        .menu-name {
            font-size: 15px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .menu-price {
            font-size: 18px;
            font-weight: 700;
            color: #ff4d6d;
            margin-bottom: 15px;
        }

        .add-btn {
            background: #ff4d6d;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .add-btn:hover {
            background: #ff3359;
            transform: translateY(-2px);
        }

        .cart-section {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            display: flex;
            flex-direction: column;
            max-height: 700px;
        }

        .cart-items {
            flex: 1;
            overflow-y: auto;
            margin-bottom: 20px;
            padding-right: 10px;
        }

        .cart-items::-webkit-scrollbar {
            width: 6px;
        }

        .cart-items::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .cart-items::-webkit-scrollbar-thumb {
            background: #ff4d6d;
            border-radius: 10px;
        }

        .cart-item {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 12px;
            transition: all 0.3s ease;
            border-left: 4px solid #ff4d6d;
        }

        .cart-item:hover {
            background: #f0f2f5;
        }

        .item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .item-name {
            font-weight: 600;
            color: #2d3748;
            font-size: 15px;
        }

        .remove-btn {
            background: #ef4444;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .remove-btn:hover {
            background: #dc2626;
        }

        .item-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .qty-control {
            display: flex;
            align-items: center;
            gap: 12px;
            background: white;
            border-radius: 8px;
            padding: 6px 10px;
            border: 1px solid #e2e8f0;
        }

        .qty-btn {
            background: #ff4d6d;
            color: white;
            border: none;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .qty-btn:hover {
            background: #ff3359;
        }

        .qty-display {
            min-width: 35px;
            text-align: center;
            font-weight: 700;
            color: #2d3748;
            font-size: 15px;
        }

        .item-subtotal {
            font-weight: 700;
            color: #ff4d6d;
            font-size: 16px;
        }

        .empty-cart {
            text-align: center;
            padding: 40px 20px;
            color: #94a3b8;
        }

        .empty-cart i {
            font-size: 70px;
            margin-bottom: 15px;
            color: #e2e8f0;
        }

        .empty-cart p {
            font-size: 16px;
            color: #94a3b8;
        }

        .cart-summary {
            border-top: 2px solid #e2e8f0;
            padding-top: 25px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 25px;
            padding: 10px;
            background: linear-gradient(135deg, #fff5f7 0%, #ffeef1 100%);
            border-radius: 12px;
            border: 2px solid #ffeef1;
        }

        .total-amount {
            color: #ff4d6d;
        }

        .payment-input-group {
            margin-bottom: 20px;
        }

        .payment-input-group label {
            display: block;
            margin-bottom: 10px;
            color: #4a5568;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .payment-input-group label i {
            color: #ff4d6d;
        }

        .payment-input-group input {
            width: 100%;
            padding: 14px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
        }

        .payment-input-group input:focus {
            outline: none;
            border-color: #ff4d6d;
            box-shadow: 0 0 0 3px rgba(255, 77, 109, 0.1);
            background: white;
        }

        .submit-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #ff4d6d 0%, #ff758f 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 17px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            box-shadow: 0 4px 15px rgba(255, 77, 109, 0.3);
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 77, 109, 0.4);
        }

        .submit-btn:disabled {
            background: #cbd5e0;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .submit-btn:disabled:hover {
            transform: none;
            box-shadow: none;
        }

        /* Clear Cart Button */
        .clear-cart-btn {
            width: 100%;
            padding: 12px;
            background: #f8f9fa;
            color: #666;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 15px;
        }

        .clear-cart-btn:hover {
            background: #ef4444;
            color: white;
            border-color: #ef4444;
        }

        /* ===== MOBILE MODE ===== */
        @media (max-width: 768px) {
            .pos-container {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
                padding: 20px;
            }

            .page-header h1 {
                font-size: 24px;
            }

            .transaction-info {
                width: 100%;
                justify-content: center;
            }

            .menu-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 15px;
            }

            .cart-section {
                max-height: 500px;
            }

            .total-row {
                font-size: 13px;
                padding: 10px;
            }
        }

        @media (max-width: 480px) {
            .menu-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .menu-card {
                padding: 15px;
            }

            .menu-icon {
                font-size: 28px;
                height: 50px;
                width: 50px;
            }

            .menu-name {
                font-size: 13px;
                height: 35px;
            }

            .menu-price {
                font-size: 15px;
            }

            .add-btn {
                padding: 8px 15px;
                font-size: 13px;
            }
        }
    </style>