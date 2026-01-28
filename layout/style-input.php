<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f5f5f5;
        padding: 20px;
    }

    .content {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 2px solid #ff4d6d;
    }

    .header h2 {
        color: #ff4d6d;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-back {
        background: #f5f5f5;
        color: #666;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.3s;
    }

    .btn-back:hover {
        background: #e0e0e0;
    }

    .btn-resep {
        background: #797c79ec;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-resep:hover {
        background: #bfc4bf;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-row {
        display: flex;
        gap: 20px;
    }

    .form-row .form-group {
        flex: 1;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }

    input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 16px;
    }

    input:focus {
        outline: none;
        border-color: #ff4d6d;
        box-shadow: 0 0 0 2px rgba(255, 77, 109, 0.2);
    }

    button {
        background: #ff4d6d;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
        width: 100%;
        margin-top: 10px;
    }

    button:hover {
        background: #ff3359;
    }

    @media (max-width: 768px) {
        .content {
            margin-left: 20px;
        }

        .form-row {
            flex-direction: column;
            gap: 10px;
        }
    }
</style>