<style>
    /* =====================
       GLOBAL
    ===================== */
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 11px;
        color: #000;
    }

    /* =====================
       WATERMARK
    ===================== */
    .watermark {
        position: fixed;
        top: 35%;
        left: 18%;
        width: 64%;
        opacity: 0.07;
        z-index: -1;
    }

    /* =====================
       KOP SURAT (FIX TERPOTONG)
    ===================== */
    .kop {
        position: relative;
        border-bottom: 2px solid #000;
        padding-top: 12px;
        /* 🔥 PENTING */
        padding-bottom: 16px;
        margin-bottom: 22px;
        min-height: 140px;
        /* 🔥 DITAMBAH */
    }

    .kop .logo {
        position: absolute;
        left: 20px;
        top: 12px;
        /* 🔥 TURUNKAN LOGO */
        width: 105px;
    }

    .kop-text {
        text-align: center;
        padding: 0 150px;
        padding-top: 6px;
        /* 🔥 PENTING */
    }

    .kop-text h2 {
        margin: 0;
        font-size: 17px;
        font-weight: bold;
        text-transform: uppercase;
        line-height: 1.3;
        /* 🔥 AMAN */
    }

    .kop-text .subjudul {
        font-size: 13px;
        font-weight: bold;
        margin-top: 4px;
        line-height: 1.2;
    }

    .kop-text .alamat {
        font-size: 10px;
        margin-top: 6px;
        line-height: 1.5;
        white-space: nowrap;
        /* 🔥 CEGAH TURUN BARIS */
    }

    /* =====================
       TABEL
    ===================== */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 6px;
    }

    th {
        background-color: #f0f0f0;
        text-align: center;
        font-weight: bold;
    }

    /* =====================
       FOOTER
    ===================== */
    footer {
        position: fixed;
        bottom: -12px;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 10px;
    }
</style>
