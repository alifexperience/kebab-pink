<style>
    /* Modal Styles */
    .modal-resep {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        padding: 20px;
    }

    .modal-content {
        background: white;
        max-width: 500px;
        margin: 50px auto;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .modal-header h3 {
        color: #ff4d6d;
        font-size: 20px;
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 24px;
        color: #999;
        cursor: pointer;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .close-btn:hover {
        background: #f5f5f5;
        color: #ff4d6d;
    }

    .modal-body {
        margin-bottom: 20px;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    .btn-modal {
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: all 0.3s;
    }

    .btn-primary {
        background: #ff4d6d;
        color: white;
    }

    .btn-primary:hover {
        background: #ff3359;
    }

    .btn-secondary {
        background: #f5f5f5;
        color: #666;
    }

    .btn-secondary:hover {
        background: #e0e0e0;
    }

    @media (max-width: 768px) {
        .modal-resep {
            padding: 10px;
        }

        .modal-content {
            margin: 20px;
            padding: 20px;
        }

        .modal-footer {
            flex-direction: column;
        }

        .btn-modal {
            width: 100%;
        }
    }
</style>