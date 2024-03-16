--
-- PostgreSQL database dump
--

-- Dumped from database version 12.1
-- Dumped by pg_dump version 12.0

-- Started on 2021-05-06 11:16:42

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 203 (class 1259 OID 53265)
-- Name: tabel_karyawan_file; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_karyawan_file (
    id_karyawanfile integer NOT NULL,
    judul character varying(128),
    keterangan character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    id_karyawan_personal integer,
    file character varying(256)
);


ALTER TABLE public.tabel_karyawan_file OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 53263)
-- Name: karyawan_file_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.karyawan_file_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.karyawan_file_id_seq OWNER TO postgres;

--
-- TOC entry 3124 (class 0 OID 0)
-- Dependencies: 202
-- Name: karyawan_file_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.karyawan_file_id_seq OWNED BY public.tabel_karyawan_file.id_karyawanfile;


--
-- TOC entry 205 (class 1259 OID 53276)
-- Name: tabel_karyawan_keluarga; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_karyawan_keluarga (
    id_karyawankeluarga integer NOT NULL,
    nama character varying(128),
    tgl_lahir character varying(16),
    status_keluarga character varying(16),
    keterangan character varying(255),
    no_kontak character varying(16),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    id_karyawan_personal integer
);


ALTER TABLE public.tabel_karyawan_keluarga OWNER TO postgres;

--
-- TOC entry 204 (class 1259 OID 53274)
-- Name: karyawan_keluarga_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.karyawan_keluarga_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.karyawan_keluarga_id_seq OWNER TO postgres;

--
-- TOC entry 3125 (class 0 OID 0)
-- Dependencies: 204
-- Name: karyawan_keluarga_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.karyawan_keluarga_id_seq OWNED BY public.tabel_karyawan_keluarga.id_karyawankeluarga;


--
-- TOC entry 207 (class 1259 OID 53287)
-- Name: tabel_karyawan_pekerjaan; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_karyawan_pekerjaan (
    id_karyawanpekerjaan integer NOT NULL,
    pekerjaan character varying(128),
    bidang character varying(128),
    instansi character varying(128),
    tahun_masuk character varying(4),
    tahun_keluar character varying(4),
    keterangan character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    id_karyawan_personal integer
);


ALTER TABLE public.tabel_karyawan_pekerjaan OWNER TO postgres;

--
-- TOC entry 206 (class 1259 OID 53285)
-- Name: karyawan_pekerjaan_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.karyawan_pekerjaan_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.karyawan_pekerjaan_id_seq OWNER TO postgres;

--
-- TOC entry 3126 (class 0 OID 0)
-- Dependencies: 206
-- Name: karyawan_pekerjaan_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.karyawan_pekerjaan_id_seq OWNED BY public.tabel_karyawan_pekerjaan.id_karyawanpekerjaan;


--
-- TOC entry 209 (class 1259 OID 53298)
-- Name: tabel_karyawan_pendidikan; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_karyawan_pendidikan (
    id_karyawanpendidikan integer NOT NULL,
    tingkat_pendidikan character varying(128),
    nama_sekolah character varying(128),
    jurusan character varying(255),
    kota character varying(255),
    nilai_akhir character varying(255),
    tahun_lulus character varying(4),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    id_karyawan_personal integer
);


ALTER TABLE public.tabel_karyawan_pendidikan OWNER TO postgres;

--
-- TOC entry 208 (class 1259 OID 53296)
-- Name: karyawan_pendidikan_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.karyawan_pendidikan_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.karyawan_pendidikan_id_seq OWNER TO postgres;

--
-- TOC entry 3127 (class 0 OID 0)
-- Dependencies: 208
-- Name: karyawan_pendidikan_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.karyawan_pendidikan_id_seq OWNED BY public.tabel_karyawan_pendidikan.id_karyawanpendidikan;


--
-- TOC entry 211 (class 1259 OID 53591)
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- TOC entry 210 (class 1259 OID 53589)
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.migrations_id_seq OWNER TO postgres;

--
-- TOC entry 3128 (class 0 OID 0)
-- Dependencies: 210
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- TOC entry 212 (class 1259 OID 53610)
-- Name: password_resets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_resets (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_resets OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 53740)
-- Name: tabel_absen_harian; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_absen_harian (
    id_absen integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    keterangan text,
    jam_masuk time(0) without time zone,
    terlambat character varying(32),
    diubaholeh character varying(64),
    diubahtgl timestamp(0) without time zone,
    alatabsen character varying(128),
    jam_plg time(0) without time zone,
    id_karyawan_personal integer,
    tgl date,
    totaljam integer,
    tahun character varying(4),
    bulan character varying(2),
    status_absen character varying(8),
    foto character varying(256),
    status_verifikasi integer,
    lat character varying(128),
    lng character varying(128),
    idatasan integer,
    alatabsen_plg character varying(128)
);


ALTER TABLE public.tabel_absen_harian OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 53738)
-- Name: tabel_absen_harian_id_kalender_kerja_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_absen_harian_id_kalender_kerja_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_absen_harian_id_kalender_kerja_seq OWNER TO postgres;

--
-- TOC entry 3129 (class 0 OID 0)
-- Dependencies: 217
-- Name: tabel_absen_harian_id_kalender_kerja_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_absen_harian_id_kalender_kerja_seq OWNED BY public.tabel_absen_harian.id_absen;


--
-- TOC entry 240 (class 1259 OID 54054)
-- Name: tabel_agama; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_agama (
    id_agama integer NOT NULL,
    agama character varying(128) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.tabel_agama OWNER TO postgres;

--
-- TOC entry 239 (class 1259 OID 54052)
-- Name: tabel_agama_id_agama_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_agama_id_agama_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_agama_id_agama_seq OWNER TO postgres;

--
-- TOC entry 3130 (class 0 OID 0)
-- Dependencies: 239
-- Name: tabel_agama_id_agama_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_agama_id_agama_seq OWNED BY public.tabel_agama.id_agama;


--
-- TOC entry 222 (class 1259 OID 53772)
-- Name: tabel_cuti; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_cuti (
    id_cuti integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    tgl_pengajuan character varying(128) NOT NULL,
    tgl_cuti_dari character varying(128) NOT NULL,
    sisa_cuti integer,
    statuskriteria_ijin character varying(64),
    keterangan text,
    statuskeputusan character varying(64),
    status_pengajuan character varying(64),
    id_karyawan_personal integer,
    tgl_cuti_sampai character varying(128),
    jml_cuti integer,
    idatasan2 integer,
    idatasan1 integer,
    alasan_tolak text,
    status character varying(16),
    suratsakit character varying(225)
);


ALTER TABLE public.tabel_cuti OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 53770)
-- Name: tabel_cuti_id_struktur_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_cuti_id_struktur_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_cuti_id_struktur_seq OWNER TO postgres;

--
-- TOC entry 3131 (class 0 OID 0)
-- Dependencies: 221
-- Name: tabel_cuti_id_struktur_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_cuti_id_struktur_seq OWNED BY public.tabel_cuti.id_cuti;


--
-- TOC entry 230 (class 1259 OID 53849)
-- Name: tabel_datang_terlambat; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_datang_terlambat (
    id_terlambat integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    hari character varying(128),
    tgl_pengajuan character varying(128),
    tgl_terlambat character varying(128),
    alasan text,
    status_pengajuan character varying(128),
    id_karyawan_personal integer,
    keterangan_atasan text,
    atasan1 integer,
    atasan2 integer,
    jam time(0) without time zone
);


ALTER TABLE public.tabel_datang_terlambat OWNER TO postgres;

--
-- TOC entry 229 (class 1259 OID 53847)
-- Name: tabel_datang_terlambat_id_detail_lembur_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_datang_terlambat_id_detail_lembur_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_datang_terlambat_id_detail_lembur_seq OWNER TO postgres;

--
-- TOC entry 3132 (class 0 OID 0)
-- Dependencies: 229
-- Name: tabel_datang_terlambat_id_detail_lembur_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_datang_terlambat_id_detail_lembur_seq OWNED BY public.tabel_datang_terlambat.id_terlambat;


--
-- TOC entry 242 (class 1259 OID 54062)
-- Name: tabel_departemen; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_departemen (
    id_departemen integer NOT NULL,
    departemen character varying(128) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.tabel_departemen OWNER TO postgres;

--
-- TOC entry 241 (class 1259 OID 54060)
-- Name: tabel_departemen_id_departemen_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_departemen_id_departemen_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_departemen_id_departemen_seq OWNER TO postgres;

--
-- TOC entry 3133 (class 0 OID 0)
-- Dependencies: 241
-- Name: tabel_departemen_id_departemen_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_departemen_id_departemen_seq OWNED BY public.tabel_departemen.id_departemen;


--
-- TOC entry 232 (class 1259 OID 53860)
-- Name: tabel_ganti_hari_kerja; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_ganti_hari_kerja (
    id_ganti_hari integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    tgl_pengajuan character varying(128),
    tgl_pengganti character varying(128),
    pekerjaan_dilakukan text,
    status_pengajuan character varying(128),
    alasan text,
    target_output text,
    jam_mulai character varying(128),
    jam_akhir character varying(128),
    id_karyawan_personal integer,
    atasan1 integer,
    atasan2 integer,
    tgl_lama character varying(128),
    hari character varying(128),
    keterangan_atasan text
);


ALTER TABLE public.tabel_ganti_hari_kerja OWNER TO postgres;

--
-- TOC entry 231 (class 1259 OID 53858)
-- Name: tabel_ganti_hari_kerja_id_terlambat_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_ganti_hari_kerja_id_terlambat_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_ganti_hari_kerja_id_terlambat_seq OWNER TO postgres;

--
-- TOC entry 3134 (class 0 OID 0)
-- Dependencies: 231
-- Name: tabel_ganti_hari_kerja_id_terlambat_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_ganti_hari_kerja_id_terlambat_seq OWNED BY public.tabel_ganti_hari_kerja.id_ganti_hari;


--
-- TOC entry 244 (class 1259 OID 54070)
-- Name: tabel_golongan; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_golongan (
    id_golongan integer NOT NULL,
    golongan character varying(128) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.tabel_golongan OWNER TO postgres;

--
-- TOC entry 243 (class 1259 OID 54068)
-- Name: tabel_golongan_id_golongan_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_golongan_id_golongan_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_golongan_id_golongan_seq OWNER TO postgres;

--
-- TOC entry 3135 (class 0 OID 0)
-- Dependencies: 243
-- Name: tabel_golongan_id_golongan_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_golongan_id_golongan_seq OWNED BY public.tabel_golongan.id_golongan;


--
-- TOC entry 246 (class 1259 OID 54078)
-- Name: tabel_jabatan; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_jabatan (
    id_jabatan integer NOT NULL,
    jabatan character varying(128) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.tabel_jabatan OWNER TO postgres;

--
-- TOC entry 245 (class 1259 OID 54076)
-- Name: tabel_jabatan_id_jabatan_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_jabatan_id_jabatan_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_jabatan_id_jabatan_seq OWNER TO postgres;

--
-- TOC entry 3136 (class 0 OID 0)
-- Dependencies: 245
-- Name: tabel_jabatan_id_jabatan_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_jabatan_id_jabatan_seq OWNED BY public.tabel_jabatan.id_jabatan;


--
-- TOC entry 254 (class 1259 OID 54121)
-- Name: tabel_jam_kerja; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_jam_kerja (
    id_jamkerja integer NOT NULL,
    jam_mulai character varying(128) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    jam_akhir character varying(128),
    keterangan character varying(16),
    jml_hari_kerja integer
);


ALTER TABLE public.tabel_jam_kerja OWNER TO postgres;

--
-- TOC entry 253 (class 1259 OID 54119)
-- Name: tabel_jam_kerja_id_jamkerja_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_jam_kerja_id_jamkerja_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_jam_kerja_id_jamkerja_seq OWNER TO postgres;

--
-- TOC entry 3137 (class 0 OID 0)
-- Dependencies: 253
-- Name: tabel_jam_kerja_id_jamkerja_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_jam_kerja_id_jamkerja_seq OWNED BY public.tabel_jam_kerja.id_jamkerja;


--
-- TOC entry 234 (class 1259 OID 53878)
-- Name: tabel_jatah_cuti; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_jatah_cuti (
    id_jatah_cuti integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    jatah_cuti character varying(128) NOT NULL,
    sisa_cuti integer,
    keterangan text,
    id_karyawan_personal integer,
    tahun integer
);


ALTER TABLE public.tabel_jatah_cuti OWNER TO postgres;

--
-- TOC entry 233 (class 1259 OID 53876)
-- Name: tabel_jatah_cuti_id_cuti_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_jatah_cuti_id_cuti_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_jatah_cuti_id_cuti_seq OWNER TO postgres;

--
-- TOC entry 3138 (class 0 OID 0)
-- Dependencies: 233
-- Name: tabel_jatah_cuti_id_cuti_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_jatah_cuti_id_cuti_seq OWNED BY public.tabel_jatah_cuti.id_jatah_cuti;


--
-- TOC entry 216 (class 1259 OID 53732)
-- Name: tabel_kalender_kerja; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_kalender_kerja (
    id_kalender_kerja integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    tgl date,
    status_hari character varying(64),
    tahun character varying(4),
    keterangan character varying(128)
);


ALTER TABLE public.tabel_kalender_kerja OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 53730)
-- Name: tabel_kalender_kerja_id_agama_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_kalender_kerja_id_agama_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_kalender_kerja_id_agama_seq OWNER TO postgres;

--
-- TOC entry 3139 (class 0 OID 0)
-- Dependencies: 215
-- Name: tabel_kalender_kerja_id_agama_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_kalender_kerja_id_agama_seq OWNED BY public.tabel_kalender_kerja.id_kalender_kerja;


--
-- TOC entry 250 (class 1259 OID 54094)
-- Name: tabel_karyawan_data; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_karyawan_data (
    id_karyawan integer NOT NULL,
    npk character varying(32) NOT NULL,
    jabatan integer,
    level integer,
    departemen integer,
    email_perusahaan character varying(128),
    no_kpj character varying(64),
    no_bpjs character varying(64),
    no_spk character varying(64),
    tgl_masuk character varying,
    mulaitgl_kontrak character varying(16),
    akhirtgl_kontrak character varying(16),
    masakerja_tahun character varying(16),
    masakerja_bulan character varying(16),
    masakerja_hari character varying(16),
    mulaitgl_evaluasi character varying(16),
    akhirtgl_evaluasi character varying(16),
    kontrak_ke character varying(2),
    status_kepegawaian character varying(2),
    masa_kontrak character varying(16),
    idfinger character varying(16),
    job_deskripsi text,
    keterangan character varying(255),
    gaji character varying(32),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    id_karyawan_personal integer,
    status character varying(2) DEFAULT 1,
    golongan integer,
    idatasan1 integer,
    idatasan2 integer,
    idjamkerja integer
);


ALTER TABLE public.tabel_karyawan_data OWNER TO postgres;

--
-- TOC entry 249 (class 1259 OID 54092)
-- Name: tabel_karyawan_data_id_karyawan_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_karyawan_data_id_karyawan_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_karyawan_data_id_karyawan_seq OWNER TO postgres;

--
-- TOC entry 3140 (class 0 OID 0)
-- Dependencies: 249
-- Name: tabel_karyawan_data_id_karyawan_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_karyawan_data_id_karyawan_seq OWNED BY public.tabel_karyawan_data.id_karyawan;


--
-- TOC entry 252 (class 1259 OID 54106)
-- Name: tabel_karyawan_personal; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_karyawan_personal (
    nama_lengkap character varying(255),
    tempatlahir character varying(255),
    tgllahir character varying(255),
    jk character varying(8),
    suku character varying(255),
    agama integer,
    status character varying(255),
    alamatktp character varying(255),
    kodeposktp character varying(255),
    foto character varying(255),
    no_kk character varying(255),
    no_ktp character varying(255),
    no_telepon character varying(255),
    no_hp character varying(255),
    email_pribadi character varying(255),
    alamat_domisili character varying(255),
    hobi character varying(255),
    npwp character varying(255),
    norek_tabungan character varying(255),
    bank_tabungan character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    id_karyawan_personal integer NOT NULL,
    status_pegawai character varying(2) DEFAULT 1,
    status_loginakun integer
);


ALTER TABLE public.tabel_karyawan_personal OWNER TO postgres;

--
-- TOC entry 251 (class 1259 OID 54104)
-- Name: tabel_karyawan_personal_id_karyawan_personal_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_karyawan_personal_id_karyawan_personal_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_karyawan_personal_id_karyawan_personal_seq OWNER TO postgres;

--
-- TOC entry 3141 (class 0 OID 0)
-- Dependencies: 251
-- Name: tabel_karyawan_personal_id_karyawan_personal_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_karyawan_personal_id_karyawan_personal_seq OWNED BY public.tabel_karyawan_personal.id_karyawan_personal;


--
-- TOC entry 214 (class 1259 OID 53724)
-- Name: tabel_kategori_absen; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_kategori_absen (
    id_kategori_absen integer NOT NULL,
    kode character varying(128) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    keterangan character varying(128),
    konsekuensi character varying(128)
);


ALTER TABLE public.tabel_kategori_absen OWNER TO postgres;

--
-- TOC entry 213 (class 1259 OID 53722)
-- Name: tabel_kategori_absen_id_agama_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_kategori_absen_id_agama_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_kategori_absen_id_agama_seq OWNER TO postgres;

--
-- TOC entry 3142 (class 0 OID 0)
-- Dependencies: 213
-- Name: tabel_kategori_absen_id_agama_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_kategori_absen_id_agama_seq OWNED BY public.tabel_kategori_absen.id_kategori_absen;


--
-- TOC entry 228 (class 1259 OID 53819)
-- Name: tabel_lembur; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_lembur (
    id_lembur integer NOT NULL,
    no_dok character varying(128),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    hari character varying(128),
    tgl_pengajuan character varying(128),
    tgl_lembur character varying(128),
    kegiatan text,
    atasan1 character varying(128),
    atasan2 character varying(128),
    catatan text,
    jam_mulai character varying(128),
    jam_akhir character varying(128),
    total_jam character varying(128),
    um character varying(128),
    id_karyawan_personal integer,
    status_pengajuan character varying(64),
    alasan_tolak text
);


ALTER TABLE public.tabel_lembur OWNER TO postgres;

--
-- TOC entry 227 (class 1259 OID 53817)
-- Name: tabel_lembur_id_jabatan_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_lembur_id_jabatan_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_lembur_id_jabatan_seq OWNER TO postgres;

--
-- TOC entry 3143 (class 0 OID 0)
-- Dependencies: 227
-- Name: tabel_lembur_id_jabatan_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_lembur_id_jabatan_seq OWNED BY public.tabel_lembur.id_lembur;


--
-- TOC entry 248 (class 1259 OID 54086)
-- Name: tabel_level; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_level (
    id_level integer NOT NULL,
    level character varying(128) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.tabel_level OWNER TO postgres;

--
-- TOC entry 247 (class 1259 OID 54084)
-- Name: tabel_level_id_level_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_level_id_level_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_level_id_level_seq OWNER TO postgres;

--
-- TOC entry 3144 (class 0 OID 0)
-- Dependencies: 247
-- Name: tabel_level_id_level_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_level_id_level_seq OWNED BY public.tabel_level.id_level;


--
-- TOC entry 235 (class 1259 OID 53931)
-- Name: tabel_log_absen; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_log_absen (
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    pin character varying(20),
    id_karyawan_personal integer,
    checktime timestamp(0) without time zone NOT NULL,
    checktype character varying(10),
    alatabsen character varying(16),
    row_id integer NOT NULL
);


ALTER TABLE public.tabel_log_absen OWNER TO postgres;

--
-- TOC entry 236 (class 1259 OID 53970)
-- Name: tabel_log_absen_row_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_log_absen_row_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_log_absen_row_id_seq OWNER TO postgres;

--
-- TOC entry 3145 (class 0 OID 0)
-- Dependencies: 236
-- Name: tabel_log_absen_row_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_log_absen_row_id_seq OWNED BY public.tabel_log_absen.row_id;


--
-- TOC entry 226 (class 1259 OID 53808)
-- Name: tabel_perjalanan_detail; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_perjalanan_detail (
    id_penugasan_karyawan integer NOT NULL,
    id_perjalan character varying(128) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    npk character varying(128),
    nama_karyawan character varying(128),
    jabatan character varying(128),
    departemen character varying(128)
);


ALTER TABLE public.tabel_perjalanan_detail OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 53806)
-- Name: tabel_penugasan_karyawan_id_level_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_penugasan_karyawan_id_level_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_penugasan_karyawan_id_level_seq OWNER TO postgres;

--
-- TOC entry 3146 (class 0 OID 0)
-- Dependencies: 225
-- Name: tabel_penugasan_karyawan_id_level_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_penugasan_karyawan_id_level_seq OWNED BY public.tabel_perjalanan_detail.id_penugasan_karyawan;


--
-- TOC entry 224 (class 1259 OID 53783)
-- Name: tabel_perjalanan_dinas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_perjalanan_dinas (
    id_penugasan integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    tgl_mulai character varying(128) NOT NULL,
    tgl_akhir character varying(128) NOT NULL,
    tujuan character varying(128) NOT NULL,
    person_dituju character varying(128) NOT NULL,
    uraian_tugas text,
    transportasi_perhari character varying(64),
    transportasi_jumlah character varying(64),
    transportasi_keterangan text,
    status_pengajuan character varying(64),
    akomodasi_perhari character varying(64),
    akomodasi_jumlah character varying(64),
    akomodasi_keterangan text,
    tm_perhari character varying(64),
    tm_jumlah character varying(64),
    tm_keterangan text,
    lain_perhari character varying(64),
    lain_jumlah character varying(64),
    lain_keterangan text,
    tgl_pengajuan date,
    pemohon character varying(128),
    ditugaskan character varying(128),
    disetujui character varying(128),
    no_formulir character varying(128)
);


ALTER TABLE public.tabel_perjalanan_dinas OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 53781)
-- Name: tabel_perjalanan_dinas_id_cuti_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_perjalanan_dinas_id_cuti_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_perjalanan_dinas_id_cuti_seq OWNER TO postgres;

--
-- TOC entry 3147 (class 0 OID 0)
-- Dependencies: 223
-- Name: tabel_perjalanan_dinas_id_cuti_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_perjalanan_dinas_id_cuti_seq OWNED BY public.tabel_perjalanan_dinas.id_penugasan;


--
-- TOC entry 220 (class 1259 OID 53764)
-- Name: tabel_struktur_jabatan; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_struktur_jabatan (
    id_struktur integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    idjabatan integer,
    idlevel integer,
    idjabatan_atasan integer,
    iddepartemen integer,
    idjamkerja integer
);


ALTER TABLE public.tabel_struktur_jabatan OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 53762)
-- Name: tabel_struktur_jabatan_id_jabatan_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_struktur_jabatan_id_jabatan_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_struktur_jabatan_id_jabatan_seq OWNER TO postgres;

--
-- TOC entry 3148 (class 0 OID 0)
-- Dependencies: 219
-- Name: tabel_struktur_jabatan_id_jabatan_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_struktur_jabatan_id_jabatan_seq OWNED BY public.tabel_struktur_jabatan.id_struktur;


--
-- TOC entry 238 (class 1259 OID 54012)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    level character varying(64),
    status_user character varying(64),
    id_karyawan_personal integer
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 237 (class 1259 OID 54010)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO postgres;

--
-- TOC entry 3149 (class 0 OID 0)
-- Dependencies: 237
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- TOC entry 2861 (class 2604 OID 53594)
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- TOC entry 2864 (class 2604 OID 53743)
-- Name: tabel_absen_harian id_absen; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_absen_harian ALTER COLUMN id_absen SET DEFAULT nextval('public.tabel_absen_harian_id_kalender_kerja_seq'::regclass);


--
-- TOC entry 2875 (class 2604 OID 54057)
-- Name: tabel_agama id_agama; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_agama ALTER COLUMN id_agama SET DEFAULT nextval('public.tabel_agama_id_agama_seq'::regclass);


--
-- TOC entry 2866 (class 2604 OID 53775)
-- Name: tabel_cuti id_cuti; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_cuti ALTER COLUMN id_cuti SET DEFAULT nextval('public.tabel_cuti_id_struktur_seq'::regclass);


--
-- TOC entry 2870 (class 2604 OID 53852)
-- Name: tabel_datang_terlambat id_terlambat; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_datang_terlambat ALTER COLUMN id_terlambat SET DEFAULT nextval('public.tabel_datang_terlambat_id_detail_lembur_seq'::regclass);


--
-- TOC entry 2876 (class 2604 OID 54065)
-- Name: tabel_departemen id_departemen; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_departemen ALTER COLUMN id_departemen SET DEFAULT nextval('public.tabel_departemen_id_departemen_seq'::regclass);


--
-- TOC entry 2871 (class 2604 OID 53863)
-- Name: tabel_ganti_hari_kerja id_ganti_hari; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_ganti_hari_kerja ALTER COLUMN id_ganti_hari SET DEFAULT nextval('public.tabel_ganti_hari_kerja_id_terlambat_seq'::regclass);


--
-- TOC entry 2877 (class 2604 OID 54073)
-- Name: tabel_golongan id_golongan; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_golongan ALTER COLUMN id_golongan SET DEFAULT nextval('public.tabel_golongan_id_golongan_seq'::regclass);


--
-- TOC entry 2878 (class 2604 OID 54081)
-- Name: tabel_jabatan id_jabatan; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_jabatan ALTER COLUMN id_jabatan SET DEFAULT nextval('public.tabel_jabatan_id_jabatan_seq'::regclass);


--
-- TOC entry 2884 (class 2604 OID 54124)
-- Name: tabel_jam_kerja id_jamkerja; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_jam_kerja ALTER COLUMN id_jamkerja SET DEFAULT nextval('public.tabel_jam_kerja_id_jamkerja_seq'::regclass);


--
-- TOC entry 2872 (class 2604 OID 53881)
-- Name: tabel_jatah_cuti id_jatah_cuti; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_jatah_cuti ALTER COLUMN id_jatah_cuti SET DEFAULT nextval('public.tabel_jatah_cuti_id_cuti_seq'::regclass);


--
-- TOC entry 2863 (class 2604 OID 53735)
-- Name: tabel_kalender_kerja id_kalender_kerja; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_kalender_kerja ALTER COLUMN id_kalender_kerja SET DEFAULT nextval('public.tabel_kalender_kerja_id_agama_seq'::regclass);


--
-- TOC entry 2880 (class 2604 OID 54097)
-- Name: tabel_karyawan_data id_karyawan; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_karyawan_data ALTER COLUMN id_karyawan SET DEFAULT nextval('public.tabel_karyawan_data_id_karyawan_seq'::regclass);


--
-- TOC entry 2857 (class 2604 OID 53268)
-- Name: tabel_karyawan_file id_karyawanfile; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_karyawan_file ALTER COLUMN id_karyawanfile SET DEFAULT nextval('public.karyawan_file_id_seq'::regclass);


--
-- TOC entry 2858 (class 2604 OID 53279)
-- Name: tabel_karyawan_keluarga id_karyawankeluarga; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_karyawan_keluarga ALTER COLUMN id_karyawankeluarga SET DEFAULT nextval('public.karyawan_keluarga_id_seq'::regclass);


--
-- TOC entry 2859 (class 2604 OID 53290)
-- Name: tabel_karyawan_pekerjaan id_karyawanpekerjaan; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_karyawan_pekerjaan ALTER COLUMN id_karyawanpekerjaan SET DEFAULT nextval('public.karyawan_pekerjaan_id_seq'::regclass);


--
-- TOC entry 2860 (class 2604 OID 53301)
-- Name: tabel_karyawan_pendidikan id_karyawanpendidikan; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_karyawan_pendidikan ALTER COLUMN id_karyawanpendidikan SET DEFAULT nextval('public.karyawan_pendidikan_id_seq'::regclass);


--
-- TOC entry 2882 (class 2604 OID 54109)
-- Name: tabel_karyawan_personal id_karyawan_personal; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_karyawan_personal ALTER COLUMN id_karyawan_personal SET DEFAULT nextval('public.tabel_karyawan_personal_id_karyawan_personal_seq'::regclass);


--
-- TOC entry 2862 (class 2604 OID 53727)
-- Name: tabel_kategori_absen id_kategori_absen; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_kategori_absen ALTER COLUMN id_kategori_absen SET DEFAULT nextval('public.tabel_kategori_absen_id_agama_seq'::regclass);


--
-- TOC entry 2869 (class 2604 OID 53822)
-- Name: tabel_lembur id_lembur; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_lembur ALTER COLUMN id_lembur SET DEFAULT nextval('public.tabel_lembur_id_jabatan_seq'::regclass);


--
-- TOC entry 2879 (class 2604 OID 54089)
-- Name: tabel_level id_level; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_level ALTER COLUMN id_level SET DEFAULT nextval('public.tabel_level_id_level_seq'::regclass);


--
-- TOC entry 2873 (class 2604 OID 53972)
-- Name: tabel_log_absen row_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_log_absen ALTER COLUMN row_id SET DEFAULT nextval('public.tabel_log_absen_row_id_seq'::regclass);


--
-- TOC entry 2868 (class 2604 OID 53811)
-- Name: tabel_perjalanan_detail id_penugasan_karyawan; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_perjalanan_detail ALTER COLUMN id_penugasan_karyawan SET DEFAULT nextval('public.tabel_penugasan_karyawan_id_level_seq'::regclass);


--
-- TOC entry 2867 (class 2604 OID 53786)
-- Name: tabel_perjalanan_dinas id_penugasan; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_perjalanan_dinas ALTER COLUMN id_penugasan SET DEFAULT nextval('public.tabel_perjalanan_dinas_id_cuti_seq'::regclass);


--
-- TOC entry 2865 (class 2604 OID 53767)
-- Name: tabel_struktur_jabatan id_struktur; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_struktur_jabatan ALTER COLUMN id_struktur SET DEFAULT nextval('public.tabel_struktur_jabatan_id_jabatan_seq'::regclass);


--
-- TOC entry 2874 (class 2604 OID 54015)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- TOC entry 3075 (class 0 OID 53591)
-- Dependencies: 211
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	2014_10_12_000000_create_users_table	1
2	2014_10_12_100000_create_password_resets_table	1
\.


--
-- TOC entry 3076 (class 0 OID 53610)
-- Dependencies: 212
-- Data for Name: password_resets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_resets (email, token, created_at) FROM stdin;
novanokkey@gmail.com	$2y$10$mpWWzmWGRAwHzOV/anLwJe316pY3Ga3NIIMmearU.yl.mqWnYWakC	2021-03-04 09:32:58
novan.abdilah@ocbd.co.id	$2y$10$td6Ap.riG843JuKQJA8ytuYdklam4wbEr3rEIYoGuPzoewg/hBnMq	2021-03-04 09:34:25
\.


--
-- TOC entry 3082 (class 0 OID 53740)
-- Dependencies: 218
-- Data for Name: tabel_absen_harian; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_absen_harian (id_absen, created_at, updated_at, keterangan, jam_masuk, terlambat, diubaholeh, diubahtgl, alatabsen, jam_plg, id_karyawan_personal, tgl, totaljam, tahun, bulan, status_absen, foto, status_verifikasi, lat, lng, idatasan, alatabsen_plg) FROM stdin;
3674	2021-05-06 09:00:54	\N	\N	09:00:54	2694.0	\N	\N	\N	\N	44	2021-05-06	\N	2021	05	\N	\N	\N	\N	\N	\N	\N
3675	2021-05-06 09:02:05	\N	\N	09:02:05	2765.0	\N	\N	\N	\N	50	2021-05-06	\N	2021	05	\N	\N	\N	\N	\N	\N	\N
3677	2021-05-06 09:04:05	\N	\N	09:04:05	2885.0	\N	\N	\N	\N	73	2021-05-06	\N	2021	05	\N	\N	\N	\N	\N	\N	\N
3678	2021-05-06 09:04:11	\N	\N	09:04:11	2891.0	\N	\N	\N	\N	65	2021-05-06	\N	2021	05	\N	\N	\N	\N	\N	\N	\N
3679	2021-05-06 09:05:43	\N	\N	09:05:43	2983.0	\N	\N	\N	\N	39	2021-05-06	\N	2021	05	\N	\N	\N	\N	\N	\N	\N
3680	2021-05-06 09:19:37	\N	\N	09:19:37	3817.0	\N	\N	\N	\N	34	2021-05-06	\N	2021	05	\N	\N	\N	\N	\N	\N	\N
3681	2021-05-06 09:21:02	\N	\N	09:21:02	3902.0	\N	\N	\N	\N	52	2021-05-06	\N	2021	05	\N	\N	\N	\N	\N	\N	\N
3683	2021-05-06 09:51:12	\N	\N	09:51:12	5712.0	\N	\N	mesin	\N	30	2021-05-06	\N	2021	05	\N	\N	1	\N	\N	74	\N
3684	2021-05-06 11:05:42	\N	\N	11:05:42	10182.0	\N	\N	mesin	\N	94	2021-05-06	\N	2021	05	\N	\N	1	\N	\N	31	\N
\.


--
-- TOC entry 3104 (class 0 OID 54054)
-- Dependencies: 240
-- Data for Name: tabel_agama; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_agama (id_agama, agama, created_at, updated_at) FROM stdin;
4	HINDU	2020-10-06 03:52:05	2020-10-06 03:52:05
1	ISLAM	\N	2020-10-06 04:34:29
2	PROTESTAN	\N	2020-10-13 02:19:39
3	KATHOLIK	\N	2020-10-13 02:19:51
5	BUDDHA	2020-10-06 03:52:18	2020-10-13 02:21:04
11	KONGHUCU	2020-10-13 02:21:37	2020-10-13 02:21:47
12	KRISTEN	2020-10-13 02:31:44	2020-10-13 02:31:44
\.


--
-- TOC entry 3086 (class 0 OID 53772)
-- Dependencies: 222
-- Data for Name: tabel_cuti; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_cuti (id_cuti, created_at, updated_at, tgl_pengajuan, tgl_cuti_dari, sisa_cuti, statuskriteria_ijin, keterangan, statuskeputusan, status_pengajuan, id_karyawan_personal, tgl_cuti_sampai, jml_cuti, idatasan2, idatasan1, alasan_tolak, status, suratsakit) FROM stdin;
23	2021-05-04 11:27:06	2021-05-04 13:18:53	2021-05-04	2021-05-04	\N	pp	sakit	\N	2	94	2021-05-04	1	10	31	\N	ijin	\N
22	2021-05-04 11:11:19	2021-05-04 13:18:56	2021-05-04	2021-05-04	\N	pp	sakit	\N	2	94	2021-05-04	1	10	31	\N	cuti	ocbd.png
\.


--
-- TOC entry 3094 (class 0 OID 53849)
-- Dependencies: 230
-- Data for Name: tabel_datang_terlambat; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_datang_terlambat (id_terlambat, created_at, updated_at, hari, tgl_pengajuan, tgl_terlambat, alasan, status_pengajuan, id_karyawan_personal, keterangan_atasan, atasan1, atasan2, jam) FROM stdin;
2	2021-04-08 14:56:28	2021-04-08 14:57:30	Kamis	2021-04-08	2021-04-16	mau ke dokter dulu pusing	3	94	pake cuti pribadi aja, nanti kena sp loh	31	10	10:00:00
1	2021-04-08 14:50:40	2021-05-04 13:28:24	Kamis	2021-04-08	2021-04-08	ke disduk	2	94	ok	31	10	10:00:00
3	2021-04-08 15:04:57	2021-05-04 13:32:20	Kamis	2021-04-08	2021-04-24	mobil mogok air radiator naik panas jadi nunggu dingin dulu	2	94	ok lanjutkan	31	10	10:00:00
\.


--
-- TOC entry 3106 (class 0 OID 54062)
-- Dependencies: 242
-- Data for Name: tabel_departemen; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_departemen (id_departemen, departemen, created_at, updated_at) FROM stdin;
1	Business Development	2020-10-06 06:36:32	2020-10-13 02:17:42
2	CEO	2020-10-06 06:36:37	2020-10-13 02:17:48
3	Finance & Accounting	2020-10-06 06:36:49	2020-10-13 02:17:52
4	HRD	2020-10-06 06:36:56	2020-10-13 02:18:00
6	IT	2020-10-13 02:18:08	2020-10-13 02:18:08
7	Legal, GA & Estate Management	2020-10-13 02:18:19	2020-10-13 02:18:19
8	Project & Engineer	2020-10-13 02:18:25	2020-10-13 02:18:25
9	Sales & Marketing	2020-10-13 02:18:32	2020-10-13 02:18:32
\.


--
-- TOC entry 3096 (class 0 OID 53860)
-- Dependencies: 232
-- Data for Name: tabel_ganti_hari_kerja; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_ganti_hari_kerja (id_ganti_hari, created_at, updated_at, tgl_pengajuan, tgl_pengganti, pekerjaan_dilakukan, status_pengajuan, alasan, target_output, jam_mulai, jam_akhir, id_karyawan_personal, atasan1, atasan2, tgl_lama, hari, keterangan_atasan) FROM stdin;
3	2021-04-13 13:57:40	2021-04-13 14:01:01	2021-04-13	2021-04-03	pasang kabel listrik dan genset	3	ke disduk	selesai	09:00:00	15:00:00	94	31	10	2021-04-01	Kamis	jangan ganti hari
4	2021-04-13 14:01:36	2021-05-04 13:41:15	2021-04-13	2021-04-17	pasang kabel listrik dan genset	2	urgent supaya tidak ganggu hari kerja	selesai	09:00:00	15:00:00	94	31	10	2021-04-16	Kamis	ok
\.


--
-- TOC entry 3108 (class 0 OID 54070)
-- Dependencies: 244
-- Data for Name: tabel_golongan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_golongan (id_golongan, golongan, created_at, updated_at) FROM stdin;
1	IA	2020-10-16 03:39:13	2020-10-16 03:39:13
2	IB	2020-10-16 03:39:17	2020-10-16 03:39:17
3	IC	2020-10-16 03:39:21	2020-10-16 03:39:21
4	ID	2020-10-16 03:39:24	2020-10-16 03:39:24
5	IIA	2020-10-16 03:39:30	2020-10-16 03:39:30
6	IIB	2020-10-16 03:39:34	2020-10-16 03:39:34
7	IIC	2020-10-16 03:39:38	2020-10-16 03:39:38
9	IID	2020-10-16 03:40:11	2020-10-16 03:40:11
10	IIIA	2020-10-16 03:40:16	2020-10-16 03:40:16
11	IIIB	2020-10-16 03:40:20	2020-10-16 03:40:20
12	IIIC	2020-10-16 03:40:24	2020-10-16 03:40:24
13	IIID	2020-10-16 03:40:29	2020-10-16 03:40:29
14	IVA	2020-10-16 03:40:33	2020-10-16 03:40:33
15	IVB	2020-10-16 03:40:38	2020-10-16 03:40:38
16	IVC	2020-10-16 03:40:42	2020-10-16 03:40:42
17	IVD	2020-10-16 03:40:46	2020-10-16 03:40:52
\.


--
-- TOC entry 3110 (class 0 OID 54078)
-- Dependencies: 246
-- Data for Name: tabel_jabatan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_jabatan (id_jabatan, jabatan, created_at, updated_at) FROM stdin;
1	Accounting & Tax SPV	\N	2020-10-13 02:07:57
2	Accounts Receivable Collection	2020-10-06 06:18:44	2020-10-13 02:08:04
3	Admin Collection	2020-10-06 06:18:54	2020-10-13 02:08:11
4	Admin Project	2020-10-06 06:19:10	2020-10-13 02:08:19
6	Admin Sales	2020-10-06 06:19:31	2020-10-13 02:08:24
7	Architect Staff	2020-10-13 02:08:30	2020-10-13 02:08:30
8	Business Development Director	2020-10-13 02:08:36	2020-10-13 02:08:36
9	Business Development GM	2020-10-13 02:08:41	2020-10-13 02:08:41
10	Content Creator	2020-10-13 02:08:45	2020-10-13 02:08:45
11	Customer Service & Housekeeping SPV	2020-10-13 02:09:48	2020-10-13 02:09:48
12	Digital Marketing	2020-10-13 02:09:53	2020-10-13 02:09:53
13	Drafter	2020-10-13 02:10:00	2020-10-13 02:10:00
14	Driver	2020-10-13 02:10:07	2020-10-13 02:10:07
15	Engineering (Estate)	2020-10-13 02:10:21	2020-10-13 02:10:21
16	Finance & Accounting Director	2020-10-13 02:10:30	2020-10-13 02:10:30
17	Finance & Treasury Manager	2020-10-13 02:10:35	2020-10-13 02:10:35
18	General Affair Staff	2020-10-13 02:10:41	2020-10-13 02:10:41
19	General Affair Supervisor	2020-10-13 02:10:46	2020-10-13 02:10:46
20	GM Sales & Marketing	2020-10-13 02:10:51	2020-10-13 02:10:51
21	Graphic Designer / Marketing Promotion	2020-10-13 02:10:56	2020-10-13 02:10:56
22	Head of Admin	2020-10-13 02:12:24	2020-10-13 02:12:24
23	Helper	2020-10-13 02:12:31	2020-10-13 02:12:31
24	Housekeeping	2020-10-13 02:12:36	2020-10-13 02:12:36
25	HR Administration & System	2020-10-13 02:12:40	2020-10-13 02:12:40
26	HR Director	2020-10-13 02:12:45	2020-10-13 02:12:45
27	HR Recruitment, Training & Development	2020-10-13 02:12:58	2020-10-13 02:12:58
28	IT Aplication Developer	2020-10-13 02:13:06	2020-10-13 02:13:06
29	IT System Support	2020-10-13 02:13:10	2020-10-13 02:13:10
30	Landscape	2020-10-13 02:13:15	2020-10-13 02:13:15
31	Landscape & Engineering Manager	2020-10-13 02:13:22	2020-10-13 02:13:22
32	Legal Manager	2020-10-13 02:13:27	2020-10-13 02:13:27
33	Legal, GA & Estate Management Executive Officer	2020-10-13 02:13:34	2020-10-13 02:13:34
34	Marcomm Support	2020-10-13 02:13:39	2020-10-13 02:13:39
35	Marketing & Communications Manager	2020-10-13 02:13:45	2020-10-13 02:13:45
36	Mechanical & Electrical Supervisor	2020-10-13 02:13:51	2020-10-13 02:13:51
37	PA to Business Development Director	2020-10-13 02:14:00	2020-10-13 02:14:00
38	Pengawas Lapangan	2020-10-13 02:14:04	2020-10-13 02:14:04
39	Planning Design	2020-10-13 02:14:09	2020-10-13 02:14:09
40	President Director	2020-10-13 02:14:14	2020-10-13 02:14:14
41	Project Manager	2020-10-13 02:14:19	2020-10-13 02:14:19
42	Quantity Surveyor	2020-10-13 02:14:25	2020-10-13 02:14:25
43	Sales & Marketing Director	2020-10-13 02:14:31	2020-10-13 02:14:31
44	Sales Executive	2020-10-13 02:14:37	2020-10-13 02:14:37
45	Sales Manager (in house)	2020-10-13 02:14:44	2020-10-13 02:14:44
46	Secretary to Director	2020-10-13 02:14:55	2020-10-13 02:14:55
47	Secretary to Finance Director	2020-10-13 02:15:07	2020-10-13 02:15:07
48	Senior Sales Executive	2020-10-13 02:15:13	2020-10-13 02:15:13
49	Staff Legal	2020-10-13 02:15:39	2020-10-13 02:15:39
50	Struktur Engineer Staff	2020-10-13 02:15:46	2020-10-13 02:15:46
51	Surveyor	2020-10-13 02:15:52	2020-10-13 02:15:52
52	Tax Staff	2020-10-13 02:15:58	2020-10-13 02:15:58
53	Treasury Staff	2020-10-13 02:16:07	2020-10-13 02:16:07
55	Personal Assistant	2021-03-08 07:28:58	2021-03-08 07:28:58
56	General Manager Busdev	2021-03-08 07:30:24	2021-03-08 07:30:24
57	Budgeting Implementation	2021-03-08 07:30:54	2021-03-08 07:30:54
58	Budgeting QS	2021-03-08 07:31:38	2021-03-08 07:31:38
59	Finance & Accounting GM	2021-03-08 07:33:42	2021-03-08 07:33:42
60	Accounting & Tax manager	2021-03-08 07:35:01	2021-03-08 07:35:01
61	Inventory Control Staff	2021-03-08 07:35:32	2021-03-08 07:35:54
62	AR Collection	2021-03-08 07:36:37	2021-03-08 07:36:37
63	Secretary & Office Management	2021-03-08 07:38:52	2021-03-08 07:38:52
64	Senior Sales Manager	2021-03-08 07:39:22	2021-03-08 07:39:22
65	Accounting Staff	2021-03-23 08:33:12	2021-03-23 08:33:12
\.


--
-- TOC entry 3118 (class 0 OID 54121)
-- Dependencies: 254
-- Data for Name: tabel_jam_kerja; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_jam_kerja (id_jamkerja, jam_mulai, created_at, updated_at, jam_akhir, keterangan, jml_hari_kerja) FROM stdin;
1	08:16:00	2021-02-09 03:33:28	2021-02-09 03:33:28	17:30:00	OFFICE	5
2	09:00:00	2021-02-09 03:35:14	2021-04-15 08:34:43	17:00:00	SALES	6
3	07:00:00	2021-04-15 08:37:12	2021-04-15 08:37:12	15:00:00	Landscape	6
4	10:00:00	2021-04-15 08:38:05	2021-04-15 08:38:05	18:00:00	Engineering	5
5	06:30:00	2021-04-15 08:38:50	2021-04-15 08:38:50	15:45:00	Housekeeping 1	5
6	08:00:00	2021-04-15 08:39:20	2021-04-15 08:39:20	17:15:00	Housekeeping 2	5
\.


--
-- TOC entry 3098 (class 0 OID 53878)
-- Dependencies: 234
-- Data for Name: tabel_jatah_cuti; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_jatah_cuti (id_jatah_cuti, created_at, updated_at, jatah_cuti, sisa_cuti, keterangan, id_karyawan_personal, tahun) FROM stdin;
88	2021-04-05 09:35:12	2021-04-08 15:20:13	5	3	-	94	2021
\.


--
-- TOC entry 3080 (class 0 OID 53732)
-- Dependencies: 216
-- Data for Name: tabel_kalender_kerja; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_kalender_kerja (id_kalender_kerja, created_at, updated_at, tgl, status_hari, tahun, keterangan) FROM stdin;
3	2021-02-09 03:20:23	2021-02-09 03:20:23	2021-02-02	hari_kerja	2021	kerja normal
2	2021-02-09 03:17:43	2021-02-09 03:25:30	2021-02-01	libur_nasional	2021	libur imlek
\.


--
-- TOC entry 3114 (class 0 OID 54094)
-- Dependencies: 250
-- Data for Name: tabel_karyawan_data; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_karyawan_data (id_karyawan, npk, jabatan, level, departemen, email_perusahaan, no_kpj, no_bpjs, no_spk, tgl_masuk, mulaitgl_kontrak, akhirtgl_kontrak, masakerja_tahun, masakerja_bulan, masakerja_hari, mulaitgl_evaluasi, akhirtgl_evaluasi, kontrak_ke, status_kepegawaian, masa_kontrak, idfinger, job_deskripsi, keterangan, gaji, created_at, updated_at, id_karyawan_personal, status, golongan, idatasan1, idatasan2, idjamkerja) FROM stdin;
55	022019185	12	11	9	rendy.dwi@ocbd.co.id	20016621490	0002458624645	197/OBP-HCM/SPK/X/2019	2019-10-21	2019-10-21	2020-10-20	\N	\N	\N	\N	\N	1	2	1	348	\N	\N	0	2020-10-14 08:09:48	2021-04-15 08:25:07	50	1	\N	78	73	1
29	022018072	39	10	1	panggih.kurnianto,@ocbd.co.id	18092135617	0001745332762	177/OBP-HCM/SPK/X/2019	2018-07-02	2019-10-01	2020-09-30	2	3	12	\N	\N	2	2	1	150	\N	\N	0	2020-10-13 08:39:38	2021-03-26 08:58:14	24	1	\N	74	11	1
39	022019124	7	11	1	aoedronick.todo@ocbd.co.id	19055178842	0001744506134	279/OBP-HCM/SPK/VII/2020	2019-04-15	2020-07-15	2021-07-14	\N	\N	\N	\N	\N	2	2	1	234	\N	\N	0	2020-10-14 03:19:58	2021-03-26 08:58:30	34	1	\N	24	74	1
35	022020021	51	10	1	yusuf.ibrahim@ocbd.co.id	19041591942	0001616382066	255/OBP-HCM/SPK/V/2020	2019-01-06	2020-05-06	2021-05-05	1	8	7	\N	\N	2	2	1	209	\N	\N	0	2020-10-14 02:36:28	2021-03-26 08:59:01	30	1	\N	74	11	1
41	022019138	23	11	1	wildan.awaludin@ocbd.co.id	19074056359	0000060246865	281/OBP-HCM/SPK/VIII/202	2019-05-17	2020-08-16	2021-08-15	\N	\N	\N	\N	\N	2	2	1	248	\N	\N	0	2020-10-14 03:31:34	2021-03-26 09:00:07	36	1	\N	30	74	1
20	022016012	47	11	3	wahyuningsih@ocbd.co.id	17021775907	0001616554091	238/OBP-HCM/SPK/II/2020	2016-11-14	2020-02-15	2022-02-14	3	10	28	\N	\N	2	2	2	39	\N	\N	0	2020-10-13 07:35:00	2021-03-26 09:01:38	15	1	\N	12	\N	1
31	022018102	52	11	3	mukhamad.imammudin@ocbd.co.id	19032249195	0001319541401	252/OBP-HCM/SPK/III/2020	2018-12-20	2020-03-20	2021-03-19	1	9	23	\N	\N	2	2	1	198	\N	\N	0	2020-10-13 08:43:19	2021-03-26 09:02:41	26	1	\N	14	12	1
43	022019146	24	6	7	burhannudin@ocbd.co.id	20008123521	0002248637084	213/OBP-HCM/SPK/I/2020	2020-01-01	2020-01-01	2020-12-31	\N	\N	\N	\N	\N	1	2	1	256	\N	\N	0	2020-10-14 03:35:14	2021-04-16 07:11:56	38	1	\N	71	10	5
15	022015001	33	1	7	virthon.hutagalung@ocbd.co.id	15040847715	0001648815884	\N	2018-08-28	\N	\N	2	1	16	\N	\N	0	3	0	\N	\N	\N	1	2020-10-13 06:57:56	2021-03-26 09:03:55	10	1	\N	23	\N	1
28	022018071	40	1	2	nsebastian@olympic-development.com	\N	\N	\N	2018-03-05	\N	\N	2	7	9	\N	\N	0	3	0	\N	\N	\N	0	2020-10-13 08:37:43	2021-03-26 08:56:44	23	1	\N	\N	\N	1
23	022018055	32	4	7	sandro.marcelino@ocbd.co.id	18041626864	0002230867596	259/OBP-HCM/SPK/VI/2020	2018-03-01	2020-06-01	2021-05-31	2	7	13	\N	\N	2	2	1	125	\N	\N	0	2020-10-13 07:45:43	2021-03-26 09:04:11	18	1	\N	10	\N	1
44	022019151	49	11	7	dina.arsitarely@ocbd.co.id	19085429595	0001620382599	180/OBP-HCM/SPK/X/2019	2019-07-15	2019-10-15	2020-10-14	\N	\N	\N	\N	\N	1	2	1	261	\N	\N	0	2020-10-14 03:41:48	2021-03-26 09:05:51	39	1	\N	18	10	1
36	022020022	19	10	7	niko.arsi@ocbd.co.id	19041591934	0002452759841	257/OBP-HCM/SPK/V/2020	2019-02-06	2020-05-06	2021-05-05	1	8	7	\N	\N	2	2	0	212	\N	\N	0	2020-10-14 02:38:49	2021-03-26 09:06:06	31	1	\N	10	\N	1
56	022019187	18	11	7	alit@ocbd.co.id	17050202443	0001125713147	183/OBP-HCM/SPK/X/2019	2019-10-25	2019-10-25	2020-10-24	\N	\N	\N	\N	\N	3	2	1	81	\N	\N	0	2020-10-14 08:11:15	2021-03-26 09:06:19	51	1	\N	31	10	1
54	022019184	29	11	6	ivan.andrian@ocbd.co.id	20016621474	0002356885967	196/OBP-HCM/SPK/X/2019	2019-10-14	2019-10-14	2020-10-13	\N	\N	\N	\N	\N	1	2	1	345	\N	\N	0	2020-10-14 08:07:24	2021-03-26 09:07:23	49	1	\N	31	10	1
52	022019178	4	11	8	mega.nur@ocbd.co.id	19032578528	PBI (APBN)	176/OBP-HCM/SPK/IX/2019	2019-01-02	2019-09-02	2020-09-01	\N	\N	\N	\N	\N	1	2	1	201	\N	\N	0	2020-10-14 04:01:14	2021-04-15 08:14:16	47	1	\N	80	\N	1
46	022019156	30	6	7	rahmat.kusnanto@ocbd.co.id	20008123463	0001126698849	215/OBP-HCM/SPK/I/2020	2020-01-01	2020-01-01	2020-12-31	\N	\N	\N	\N	\N	1	2	1	273	\N	\N	0	2020-10-14 03:44:55	2021-04-16 07:17:28	41	1	\N	40	10	3
48	022019159	30	6	7	sumarta@ocbd.co.id	20008123430	0001454636834	217/OBP-HCM/SPK/I/2020	2020-01-01	2020-01-01	2020-12-31	\N	\N	\N	\N	\N	1	2	1	277	\N	\N	0	2020-10-14 03:54:12	2021-04-16 07:21:29	43	1	\N	40	10	3
21	022017035	25	11	4	prasetiawan@ocbd.co.id	17028323016	0001833574959	260/OBP-HCM/SPK/VI/2020	2017-03-01	2020-01-01	2021-05-31	3	7	13	\N	\N	2	2	1	2	\N	\N	0	2020-10-13 07:39:08	2021-03-26 08:44:41	16	1	\N	13	\N	1
16	022016001	8	1	1	yannes.pasaribu@ocbd.co.id	17021775782	0002135671637	\N	2016-09-01	\N	\N	4	1	11	\N	\N	0	3	0	\N	\N	\N	0	2020-10-13 07:09:17	2021-03-26 08:57:02	11	1	\N	23	\N	1
18	022016004	26	1	9	imelda.fransisca@ocbd.co.id	17021775881	0002103313307	\N	2016-11-11	\N	\N	3	11	1	\N	\N	0	3	0	\N	\N	\N	0	2020-10-13 07:12:34	2021-04-15 08:15:16	13	1	\N	23	\N	1
32	022019012	46	10	9	femmy.tantiana@ocbd.co.id	11024771112	0001657459293	189/OBP-HCM/SPK/I/2020	2019-01-01	2020-01-01	2020-12-31	1	9	11	\N	\N	2	2	1	47	\N	\N	0	2020-10-13 08:46:12	2021-04-15 08:15:51	27	1	\N	13	\N	1
34	022020020	53	11	3	derin.romalia@ocbd.co.id	19048410278	0001658839498	256/OBP-HCM/SPK/VI/2020	2019-01-16	2020-06-01	2021-05-31	1	8	28	\N	\N	2	2	1	206	\N	\N	0	2020-10-14 02:34:26	2021-04-16 06:56:39	29	1	\N	14	12	1
51	022019176	30	6	7	lukman.nulhakim@ocbd.co.id	20008123471	0001654525506	219/OBP-HCM/SPK/I/2020	2020-01-01	2020-01-01	2020-12-31	\N	\N	\N	\N	\N	1	2	1	296	\N	\N	0	2020-10-14 03:59:47	2021-04-16 07:22:03	46	1	\N	40	10	3
22	022017036	44	11	9	angga.eka@ocbd.co.id	19032249161	\N	190/OBP-HCM/SPK/X/2019	2017-10-02	2019-10-02	2020-10-01	3	\N	11	02/04/2020	01/07/2020	1	2	1	82	\N	\N	0	2020-10-13 07:41:43	2021-04-16 07:40:54	17	1	\N	55	72	2
33	022020019	44	11	9	sartika.puji@ocbd.co.id	\N	Ada tunggakan	230/OBP-HCM/SPK/I/2020	2019-01-10	2020-01-10	2021-01-09	1	9	3	10/04/2020	09/07/2020	1	2	1	204	\N	\N	0	2020-10-14 02:32:25	2021-04-16 07:42:03	28	1	\N	55	72	2
49	022019162	38	10	8	ryan.andresta@ocbd.co.id	20008123505	0001373380784	212/OBP-HCM/SPK/I/2020	2019-09-02	2020-01-01	2020-12-31	\N	\N	\N	\N	\N	1	2	1	305	\N	\N	0	2020-10-14 03:56:05	2021-04-15 08:13:40	44	1	\N	80	\N	1
27	022018070	27	11	4	suhartin.ekafacksi@ocbd.co.id	19032249153	0001106036842	251/OBP-HCM/SPK/III/2020	2018-12-27	2020-03-27	2021-03-26	1	9	16	\N	\N	2	2	1	199	\N	\N	0	2020-10-13 08:07:34	2021-04-29 08:50:25	22	1	\N	13	\N	1
25	022020011	48	11	9	nina.marlina@ocbd.co.id	\N	0001870501285	209/OBP-HCM/SPK/XII/2019	2018-03-12	2019-12-12	2020-12-11	2	7	2	12/06/2020	11/09/2020	1	2	1	133	\N	\N	0	2020-10-13 08:00:53	2021-04-16 07:44:04	20	1	\N	53	72	2
26	022018065	48	11	9	agus.setiawan@ocbd.co.id	\N	0002356440748	210/OBP-HCM/SPK/XII/2019	2018-03-12	2019-12-12	2020-12-11	2	7	2	\N	\N	1	2	1	135	\N	\N	0	2020-10-13 08:03:51	2021-04-16 07:43:16	21	1	\N	72	73	2
59	022019193	44	11	9	bepin.zahari@ocbd.co.id	\N	0002923799782	202/OBP-HCM/SPK/XI/2019	2019-11-11	2019-11-11	2020-11-10	\N	\N	\N	11/05/2020	10/08/2020	1	2	1	355	\N	\N	0	2020-10-14 08:17:16	2021-04-16 07:42:38	54	1	\N	55	72	2
75	022020218	7	11	1	adhithia.sigit@ocbd.co.id	18009603376	0002144053269	245/OBP-HCM/SPK/III/2020	2017-11-01	2020-03-01	2021-02-28	\N	\N	\N	\N	\N	3	2	1	96	\N	\N	0	2020-10-15 02:37:01	2021-03-26 08:58:46	70	1	\N	24	74	1
62	022019197	3	11	3	putri.permatasari@ocbd.co.id	20024357517	0000041956896	206/OBP-HCM/SPK/XI/2019	2019-12-16	2019-12-16	2020-12-15	\N	\N	\N	\N	\N	1	2	1	360	\N	\N	0	2020-10-14 08:22:39	2021-03-26 09:03:35	57	1	\N	25	14	1
81	022020225	24	6	7	sofyan.akbar@ocbd.co.id	18028160218	0001627202902	254/OBP-HCM/SPK/V/2020	2018-01-17	2020-05-18	2021-05-17	\N	\N	\N	\N	\N	3	2	1	116	\N	\N	0	2020-10-15 02:51:56	2021-03-26 09:06:34	76	1	\N	31	10	1
65	022020204	14	6	7	ahmad.fauzi@ocbd.co.id	20029755988	0001107581163	228/OBP-HCM/SPK/I/2020	2020-01-08	2020-01-08	2021-01-07	\N	\N	\N	\N	\N	1	2	1	365	\N	\N	0	2020-10-15 02:09:37	2021-03-26 09:07:39	60	1	\N	31	10	1
68	022020208	14	6	7	wawan.sugianto@ocbd.co.id	17021776046	0002076153131	234/OBP-HCM/SPK/II/2020	2016-01-01	2020-02-01	2021-01-31	\N	\N	\N	\N	\N	3	2	1	398	\N	\N	0	2020-10-15 02:15:08	2021-03-26 09:07:52	63	1	\N	31	10	1
76	022020219	11	10	7	dwi.wulandari@ocbd.co.id	17021775790	0002103575703	246/OBP-HCM/SPK/III/2020	2016-12-01	2020-03-16	2021-03-15	\N	\N	\N	\N	\N	3	2	1	40	\N	\N	0	2020-10-15 02:38:24	2021-03-26 09:08:08	71	1	\N	10	\N	1
61	022019196	38	11	8	sunardi@ocbd.co.id	20024357525	0002924008986	205/OBP-HCM/SPK/XI/2019	2019-12-02	2019-12-02	2020-12-01	\N	\N	\N	\N	\N	1	2	1	358	\N	\N	0	2020-10-14 08:20:05	2021-04-15 08:13:59	56	1	\N	80	\N	1
86	022020230	24	6	7	alfarisi@ocbd.co.id	18115520381	0002493029542	265/OBP-HCM/SPK/VII/2020	2018-09-03	2020-07-01	2021-06-30	\N	\N	\N	\N	\N	3	2	1	174	\N	\N	0	2020-10-15 03:00:02	2021-04-16 07:15:23	81	1	\N	71	10	6
88	022020232	24	6	7	muhamad.ramdani@ocbd.co.id	\N	\N	267/OBP-HCM/SPK/VI/2020	2020-06-26	2020-06-26	2021-06-25	\N	\N	\N	26/06/2020	25/09/2020	1	2	1	384	\N	\N	0	2020-10-15 03:04:58	2021-04-16 07:15:54	83	1	\N	71	10	5
95	022020239	24	6	7	dedi.anggoro@ocbd.co.id	\N	\N	\N	2020-07-05	2020-07-05	2020-07-04	\N	\N	\N	05/07/2020	04/10/2020	1	2	1	395	\N	\N	0	2020-10-15 03:18:25	2021-04-16 07:16:25	90	1	\N	71	10	5
63	022019199	30	6	7	farhan.jamil@ocbd.co.id	20029754536	0002932578202	220/OBP-HCM/SPK/I/2020	2020-01-01	2020-01-01	2020-12-31	\N	\N	\N	\N	\N	1	2	1	362	\N	\N	0	2020-10-14 08:24:03	2021-04-16 07:22:47	58	1	\N	40	10	3
79	022020223	9	3	1	hendrik.indra@ocbd.co.id	18017246135	0001621312784	250/OBP-HCM/SPK/IV/2020	2017-12-05	2020-04-06	2021-04-05	\N	\N	\N	\N	\N	3	2	1	98	\N	\N	0	2020-10-15 02:47:53	2021-03-26 08:57:47	74	1	\N	11	\N	1
78	022020221	20	3	9	meilyana@ocbd.co.id	20040818062	0001474063751	248/OBP-HCM/SPK/III/2020	2020-03-02	2020-03-02	2021-02-28	\N	\N	\N	\N	\N	1	2	1	377	\N	\N	0	2020-10-15 02:41:59	2021-04-15 08:15:33	73	1	\N	13	\N	1
74	022020217	44	11	9	muhamad.noor@ocbd.co.id	\N	0002328725136	244/OBP-HCM/SPK/II/2020	2020-02-11	2020-02-11	2021-02-10	\N	\N	\N	11/05/2020	10/08/2020	1	2	1	375	\N	\N	0	2020-10-15 02:34:36	2021-04-16 07:41:28	69	1	\N	55	72	2
60	022019195	45	4	9	marini@ocbd.co.id	20016621482	PNS	204/OBP-HCM/SPK/XI/2019	2019-11-15	2019-11-15	2020-11-14	\N	\N	\N	15/05/2020	14/11/2020	1	2	1	357	\N	\N	0	2020-10-14 08:18:51	2021-04-16 07:40:09	55	1	\N	72	73	2
37	022019118	6	11	9	luqman.al@ocbd.co.id	19055178834	0001736937641	264/OBP-HCM/SPK/VII/2020	2019-04-01	2020-07-01	2021-05-30	\N	\N	\N	\N	\N	1	2	0	225	0	0	0	2020-10-14 03:13:44	2021-04-15 08:24:00	32	1	\N	64	73	1
67	022020206	24	6	7	ahmad.nawawi@ocbd.co.id	20029755749	0001129223057	232/OBP-HCM/SPK/I/2020	2020-01-13	2020-01-13	2021-01-12	\N	\N	\N	\N	\N	1	2	1	367	\N	\N	0	2020-10-15 02:13:09	2021-04-16 07:14:52	62	1	\N	71	10	5
77	022020220	45	4	9	theodore.david@ocbd.co.id	20040818088	0001636111653	247/OBP-HCM/SPK/III/2020	2020-03-02	2020-03-02	2021-02-28	\N	\N	\N	01/05/2020	30/11/2020	1	2	1	376	\N	\N	0	2020-10-15 02:40:23	2021-04-16 07:39:32	72	1	\N	73	13	2
89	022020233	30	6	7	muhamad.ibnu@ocbd.co.id	\N	\N	268/OBP-HCM/SPK/VI/2020	2020-06-29	2020-06-29	2021-06-28	\N	\N	\N	29/06/2020	29/09/2020	1	2	1	385	\N	\N	0	2020-10-15 03:07:10	2021-04-16 07:24:21	84	1	\N	40	10	3
80	022020224	21	11	9	asep.saepulloh@ocbd.co.id	20040818096	0002278234528	253/OBP-HCM/SPK/V/2020	2020-05-01	2020-05-01	2021-04-30	\N	\N	\N	\N	\N	1	2	1	64	\N	\N	0	2020-10-15 02:50:33	2021-04-16 07:37:40	75	1	\N	78	73	1
85	022020229	41	4	8	zakaria@ocbd.co.id	18041046758	0001635681126	263/OBP-HCM/SPK/VII/2020	2018-03-01	2019-07-01	2021-06-30	\N	\N	\N	\N	\N	3	2	1	124	\N	\N	0	2020-10-15 02:58:24	2021-04-16 07:59:03	80	1	\N	112	\N	1
69	022020209	22	10	9	enjang.misbah@ocbd.co.id	18056501432	0002356440759	235/OBP-HCM/SPK/II/2020	2018-04-02	2020-02-01	2022-01-31	\N	\N	\N	\N	\N	3	2	2	138	\N	\N	0	2020-10-15 02:16:55	2021-04-15 08:23:43	64	1	\N	73	13	1
70	022020212	34	6	9	arip.rahman@ocbd.co.id	20040818070	0001722763056	239/OBP-HCM/SPK/I/2020	2020-01-22	2020-01-22	2021-01-21	\N	\N	\N	\N	\N	1	2	1	370	\N	\N	0	2020-10-15 02:18:41	2021-04-15 08:25:39	65	1	\N	75	78	1
112	022121256	65	11	3	\N	\N	\N	336/OBP-HCM/SPK/II/2021	2021-02-04	2021-02-04	2021-04-30	\N	\N	\N	\N	\N	1	2	0	405	\N	\N	\N	2021-03-23 08:32:50	2021-03-26 09:02:17	102	1	1	14	12	1
101	022020246	44	11	9	\N	\N	\N	283/OBP-HCM/SPK/IX/2020	2020-09-01	2020-09-01	2021-08-31	\N	\N	\N	01/09/2020	30/11/2020	1	2	1	94	\N	\N	0	2020-10-15 07:11:56	2021-04-30 06:33:34	96	1	\N	21	72	2
45	022019152	31	4	7	eko.wiyantono@ocbd.co.id	20008123455	0001804648904	229/OBP-HCM/SPK/I/2020	2019-10-09	2020-01-09	2021-01-08	\N	\N	\N	\N	\N	1	2	1	263	\N	\N	0	2020-10-14 03:43:16	2021-03-26 09:08:24	40	1	\N	10	\N	1
108	022021259	10	11	9	\N	\N	\N	322/OBP-HCM/SPK/I/2021	2021-01-04	2021-01-04	2022-01-03	\N	\N	\N	\N	\N	1	2	1	413	\N	\N	\N	2021-03-23 04:47:47	2021-03-26 09:18:02	108	1	1	78	73	1
116	022121258	35	4	9	\N	\N	\N	\N	\N	2021-04-01	2022-05-01	\N	\N	\N	\N	\N	1	1	1	425	\N	\N	\N	2021-04-29 09:13:01	2021-04-29 09:13:01	115	1	1	73	\N	1
58	022019192	48	11	9	rizki@ocbd.co.id	\N	0002037773586	201/OBP-HCM/SPK/XI/2019	2019-11-11	2019-11-11	2020-11-10	\N	\N	\N	11/05/2020	10/08/2020	1	2	1	354	\N	\N	0	2020-10-14 08:15:21	2021-04-16 07:45:05	53	1	\N	72	73	2
99	022020243	28	11	6	novan.abdilah@ocbd.co.id	\N	\N	\N	2020-07-20	2020-07-20	2021-07-19	\N	\N	\N	20/07/2020	19/10/2020	1	2	1	397	\N	\N	0	2020-10-15 03:25:56	2021-03-26 07:01:20	94	1	\N	31	10	1
57	022019188	37	11	1	jeffry.alvianto@ocbd.co.id	20016621466	0001863344452	198/OBP-HCM/SPK/X/2019	2019-10-28	2019-10-28	2020-10-27	\N	\N	\N	\N	\N	1	2	1	350	\N	\N	0	2020-10-14 08:12:45	2021-03-26 08:57:33	52	1	\N	74	11	1
19	022016012	17	4	3	shelly.maryanti@ocbd.co.id	17021775915	0002103575714	188/OBP-HCM/SPK/XII/2019	2016-09-19	2019-12-19	2020-12-18	4	\N	23	\N	\N	2	2	1	23	\N	\N	0	2020-10-13 07:18:14	2021-03-26 09:01:58	14	1	\N	12	\N	1
71	022020213	36	10	8	nurwanto@ocbd.co.id	17059467906	0001863868252	240/OBP-HCM/SPK/I/2020	2017-08-01	2020-01-01	2020-12-31	\N	\N	\N	\N	\N	1	2	1	68	\N	\N	0	2020-10-15 02:20:08	2021-04-15 08:13:22	66	1	\N	80	\N	1
66	022020205	15	11	7	suci.fitriyanto@ocbd.co.id	20034285872	0001635190839	231/OBP-HCM/SPK/I/2020	2020-01-13	2020-01-13	2021-01-12	\N	\N	\N	\N	\N	1	2	1	366	\N	\N	0	2020-10-15 02:11:13	2021-04-16 07:07:10	61	1	\N	40	10	4
42	022019145	24	6	7	muchlis@ocbd.co.id	20008123448	PBI (JAMKESDA KAB. BOGOR)	214/OBP-HCM/SPK/I/2020	2020-01-01	2020-01-01	2020-12-31	\N	\N	\N	\N	\N	1	2	1	255	\N	\N	0	2020-10-14 03:33:32	2021-04-16 07:11:18	37	1	\N	71	10	5
64	022020201	30	6	7	ridwan@ocbd.co.id	20008123513	PBI (APBN)	224/OBP-HCM/SPK/I/2020	2020-01-01	2020-01-01	2020-12-31	\N	\N	\N	\N	\N	1	2	1	383	\N	\N	0	2020-10-15 02:07:50	2021-04-16 07:23:42	59	1	\N	40	10	3
113	022121257	41	1	8	yohanes@olympic-development.com	17028242786	0001882260707	\N	2017-03-01	2017-03-01	2021-12-31	\N	\N	\N	\N	\N	4	3	4	0	\N	\N	\N	2021-04-16 07:58:25	2021-04-16 07:58:25	112	1	14	\N	\N	1
38	022019123	13	11	8	ardian.hary@ocbd.co.id	19055178867	0002893323633	278/OBP-HCM/SPK/VII/2020	2019-04-15	2020-06-15	2021-06-14	\N	\N	\N	\N	\N	2	2	0	232	\N	\N	0	2020-10-14 03:17:28	2021-04-16 07:59:29	33	1	\N	112	\N	1
111	022121255	50	11	8	\N	921039616815	\N	338/OBP-HCM/SPK/II/2021	2021-02-15	2021-02-15	2022-02-14	\N	\N	\N	\N	\N	1	2	1	415	\N	\N	\N	2021-03-23 08:19:07	2021-04-16 08:00:15	111	1	1	112	\N	1
100	022020086	30	6	7	andika.maulana@ocbd.co.id	\N	\N	\N	2020-08-25	2020-08-25	2021-08-24	\N	\N	\N	25/08/2020	24/11/2020	1	2	1	399	\N	\N	0	2020-10-15 03:28:46	2021-04-29 09:03:05	95	1	\N	40	10	3
115	022021268	44	11	9	\N	\N	\N	\N	\N	2021-01-01	2022-01-01	\N	\N	\N	\N	\N	1	1	1	421	\N	\N	\N	2021-04-29 09:10:22	2021-04-29 09:10:39	114	1	1	73	\N	2
114	022021267	1	10	3	\N	\N	\N	\N	\N	2021-04-01	2022-05-01	\N	\N	\N	\N	\N	1	1	1	420	\N	\N	\N	2021-04-29 09:08:35	2021-04-29 09:10:58	113	1	1	14	\N	1
106	022021257	44	11	9	\N	921019271966	\N	320/OBP-HCM/SPK/I/2021	2021-01-02	2021-01-02	2021-12-31	\N	\N	\N	\N	\N	1	2	1	414	\N	\N	\N	2021-03-23 04:30:16	2021-04-30 06:22:06	106	1	1	21	72	2
103	022021252	44	11	9	\N	921019271966	\N	315/OBP-HCM/SPK/I/2021	2021-01-02	2021-01-02	2021-12-31	\N	\N	\N	\N	\N	1	2	1	410	\N	\N	\N	2021-03-23 03:42:57	2021-04-30 06:35:54	103	1	1	53	72	2
107	022121254	44	11	9	\N	\N	\N	321/OBP-HCM/SPK/I/2021	2021-01-02	2021-01-02	2021-12-31	\N	\N	\N	\N	\N	1	2	1	416	\N	\N	\N	2021-03-23 04:37:08	2021-04-30 06:36:53	107	1	1	21	72	2
109	022021260	44	11	9	\N	\N	\N	323/OBP-HCM/SPK/I/2021	2021-01-07	2021-01-07	2022-01-06	\N	\N	\N	\N	\N	1	2	1	417	\N	\N	\N	2021-03-23 04:52:04	2021-04-30 06:38:16	109	1	1	53	72	2
110	022021261	30	6	7	\N	\N	\N	331/OBP-HCM/SPK/I/2021	2021-01-15	2021-01-15	2022-01-14	\N	\N	\N	\N	\N	1	2	1	418	\N	\N	\N	2021-03-23 08:14:06	2021-04-30 06:40:16	110	1	1	40	10	3
105	022021255	44	11	9	\N	921019271966	\N	318/OBP-HCM/SPK/I/2021	2021-01-02	2021-01-02	2021-12-31	\N	\N	\N	\N	\N	1	2	1	411	\N	\N	\N	2021-03-23 04:23:30	2021-03-23 04:26:52	105	1	1	21	72	1
\.


--
-- TOC entry 3067 (class 0 OID 53265)
-- Dependencies: 203
-- Data for Name: tabel_karyawan_file; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_karyawan_file (id_karyawanfile, judul, keterangan, created_at, updated_at, id_karyawan_personal, file) FROM stdin;
17	foto	tes	2020-11-26 07:45:33	2020-11-26 07:45:33	10	1606376733ocbd.jpg
18	kk	\N	2020-11-26 07:48:36	2020-11-26 07:48:36	26	1606376916Kartu Keluarga Mukhmad Imammudin.pdf
19	lain	CV	2020-11-26 07:49:20	2020-11-26 07:49:20	26	1606376960Kartu Keluarga Mukhmad Imammudin.pdf
\.


--
-- TOC entry 3069 (class 0 OID 53276)
-- Dependencies: 205
-- Data for Name: tabel_karyawan_keluarga; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_karyawan_keluarga (id_karyawankeluarga, nama, tgl_lahir, status_keluarga, keterangan, no_kontak, created_at, updated_at, id_karyawan_personal) FROM stdin;
\.


--
-- TOC entry 3071 (class 0 OID 53287)
-- Dependencies: 207
-- Data for Name: tabel_karyawan_pekerjaan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_karyawan_pekerjaan (id_karyawanpekerjaan, pekerjaan, bidang, instansi, tahun_masuk, tahun_keluar, keterangan, created_at, updated_at, id_karyawan_personal) FROM stdin;
\.


--
-- TOC entry 3073 (class 0 OID 53298)
-- Dependencies: 209
-- Data for Name: tabel_karyawan_pendidikan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_karyawan_pendidikan (id_karyawanpendidikan, tingkat_pendidikan, nama_sekolah, jurusan, kota, nilai_akhir, tahun_lulus, created_at, updated_at, id_karyawan_personal) FROM stdin;
\.


--
-- TOC entry 3116 (class 0 OID 54106)
-- Dependencies: 252
-- Data for Name: tabel_karyawan_personal; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_karyawan_personal (nama_lengkap, tempatlahir, tgllahir, jk, suku, agama, status, alamatktp, kodeposktp, foto, no_kk, no_ktp, no_telepon, no_hp, email_pribadi, alamat_domisili, hobi, npwp, norek_tabungan, bank_tabungan, created_at, updated_at, id_karyawan_personal, status_pegawai, status_loginakun) FROM stdin;
Norman Edward Sebastian	Jakarta	04 Maret 1983	L	\N	12	K2	Taman Kebon Jeruk Blok G1/95 Rt 02/11 Kel Srengseng Kec Kembangan, Kota Jakarta Barat	\N	\N	3173081001091618	3173080403830005	\N	\N	nsebastian@pt-nes.com	\N	\N	\N	0840574440	BCA	2020-10-13 03:08:56	2020-10-13 03:08:56	23	1	\N
Imelda Fransisca	Bogor	24 September 1982	P	\N	12	K2	Taman Kebon Jeruk Blok G1/95 Rt 02/11 Kel Srengseng Kec Kembangan, Kota Jakarta Barat	\N	1606379023_MG_1110.JPG	3173081001091618	3173086409820001	\N	0811110122	\N	\N	\N	092238781404000	5005009119	BCA	2020-10-13 02:42:52	2021-04-15 08:03:04	13	1	1
Shelly Maryanti	Jambi	07 Agustus 1994	P	\N	12	K1	Perumahan Muara Asri No 38D Rt 03/ Rw 12 Kel Pasirkuda Kec Bogor Barat	\N	\N	3271012307190017	3271044708940003	02518347470	085210068333	\N	Perumahan Muara Asri No 38D Rt 03/ Rw 12 Kel Pasirkuda Kec Bogor Barat	\N	748460144404000	4278004366	BCA	2020-10-13 02:44:46	2021-04-15 08:03:08	14	1	1
Virthon Hutagalung	Medan	24 November 1972	L	batak	2	K3	Jln. Pagelaran Asogiri Komp. Tbi Kav 93 No. A2 Rt 03/Rw 04 Kel. Tanah Baru Kec. Bogor Utara	16154	1603768758Pak virthon.jpg	3271050807080028	3271052411720010	\N	08125401232	\N	Jln. Pagelaran Asogiri Komp. Tbi Kav 93 No. A2 Rt 03/Rw 04 Kel. Tanah Baru Kec. Bogor Utara	Musik, Traveling	672565736404000	7380538797	BCA	2020-10-13 02:29:09	2021-03-10 07:25:57	10	1	1
Suhartin Ekafacksi	Jakarta	14 April 1989	P	jawa	1	K1	Jl. Krakatau VI No 276 RT 09/09 Kel. Abadijaya Kec. Sukmajaya Kota Depok	16417	\N	3276051111150010	3175055404890008	\N	087780878348	eka.facksi@yahoo.com	Jl. Swadaya Raya, Kp. Muara Beres RT 02 RW 04 Kel. Sukahati Kec. Cibinong, Kab Bogor	Membaca	458481207009000	4661323030	BCA	2020-10-13 03:08:00	2021-03-10 08:17:46	22	1	1
Niko Arsi Harkenijandra	Jakarta	29 Oktober 1984	L	jawa	1	BK	Kav. DKI Blok 40/16 RT 02 RW 10 Kel Meruya Utara Kec. Kembangan Jakarta Barat	11620	\N	3173082604180001	3173082910840008	\N	08787693747	niko_arsi@yahoo.com, nikoarsi16@gmail.com	Jl. Penyelesaian Tomang II .Kav. DKI Blok 40/16 RT 02 RW 10 Kel Meruya Utara Kec. Kembangan Jakarta Barat	Basket	674328836086000	3721125333	BCA	2020-10-13 03:24:11	2021-04-15 08:00:12	31	1	1
Wahyuningsih	Kediri	09 Januari 1977	P	jawa	1	K1	Jl Pramuka Kompl Al No 11 Rt 14/ 08 Kel Rawasari Kec Cempaka Putih	\N	\N	\N	3171054901770003	\N	081357497646	\N	Perum Kota Wisata, Cluster Calgary Blok Ue 5 No. 32	Baca,Olahraga	874530207003000	0953763301	BCA	2020-10-13 02:46:45	2021-04-15 08:03:11	15	1	1
Angga Eka Putra	Bogor	15 Juli 1983	L	sunda	1	K2	Kp. Rawa Rt 02 Rw 02 Kel. Gadog Kec. Megamendung, Kab. Bogor	\N	\N	3201261409110010	3201261507830022	\N	0895377809071	ghaw.genfrust46@gmail.com	Jl. Raya Puncak Gadog Kp. Rawa Rt 02 Rw 02 Kel. Gadog Kec.Megamendung, Kab. Bogor	Olah Raga	458814209434000	0953765575	BCA	2020-10-13 02:51:51	2021-04-15 08:03:16	17	1	1
Luqman Al Hakim	Depok	14 Juni 1987	L	sunda	1	K1	Kp. Sengon Rt 10 Rw 10 No 52 Kec. Pancoranmas Kel. Pancoranmas Kota Depok	16436	\N	3276011902160017	3276011406870008	\N	081287822445	luqman1406@gmail.com	Kp. Sengon Rt 10 Rw 10 No 52 Kec. Pancoranmas Kel. Pancoranmas Kota Depok	Olah Raga	256659566412000	6040862861	BCA	2020-10-13 03:30:25	2021-04-15 09:01:27	32	1	1
Panggih Kurnianto, S.T.	Magelang	23 Desember 1989	L	jawa	12	K1	Semanggi Rt 06 Rw 09 Kel. Semanggi Kec. Pasar Kliwon Kota Surakarta	57117	\N	3372031401160006	3371012312890003	\N	081250194594	panggih.kurnianto@gmail.com	Semanggi Rt 06 Rw 09 Kel. Semanggi Kec. Pasar Kliwon Kota Surakarta	\N	736195793524000	0097081313	BCA	2020-10-13 03:10:24	2021-04-16 06:52:02	24	1	1
Yusuf Ibrahim	Bogor	02 Februari 1976	L	sunda	1	K4	Ciherang Kidul RT 04 RW 03 Kel. Laladon Kec. Ciomas Kab. Bogor	\N	\N	\N	3201290202760002	\N	081574377383	yusufibrahim96.yi@gmail.com	Ciherang Kidul RT 04 RW 03 Kel. Laladon Kec. Ciomas Kab. Bogor	Bulu Tangkis	686713801434000	8720372909	BCA	2020-10-13 03:21:31	2021-04-16 06:53:06	30	1	1
Mukhamad Imammudin	Bogor	03 Juni 1995	L	sunda	1	K1	Jl. Perkesa Kav DPRD No. 1 RT 01 RW 18 Kel. Cipaku  Kec. Lota Bogor Selatan	16133	\N	3271012410170017	3271010306950017	\N	085887236279	imammudin735@gmail.com	Jl. Perkesa Kav DPRD No. 1 RT 01 RW 18 Kel. Cipaku  Kec. Lota Bogor Selatan	Olah Raga	985411214404000	0953295340	BCA	2020-10-13 03:14:50	2021-04-16 06:55:55	26	1	1
Derin Romalia	Bogor	28 Maret 1991	P	sunda	1	KI	Kampung Sawah RT 01 RW 11 Kel. Cibinong Kec. Cibinong Kab. Bogor	16911	\N	3201010202160044	3201016803910004	\N	081321205115	derinromalia@gmail.com	Kampung Sawah RT 01 RW 11 Kel. Cibinong Kec. Cibinong Kab. Bogor	\N	479081994403000	0845119754	BCA	2020-10-13 03:20:17	2021-04-16 06:56:19	29	1	1
Femmy Tantiana	Bogor	17 Maret 1987	P	sunda	1	K1	Jl Arzimar Ii No 20 Rt 05/02 Gg Mesjid Kel Tegal Gundil Kec Bantarjati - Kota Bogor	16152	\N	3271051308150010	3271055703870007	(0251) 8316352	081311150523, 087770621665	fe.sakhi@yahoo.co.id	Jl Arzimar Ii No 20 Rt 05/02 Gg Mesjid Kel Tegal Gundil Kec Bantarjati - Kota Bogor	\N	249125519404000	0953460626	BCA	2020-10-13 03:16:04	2021-04-16 07:33:46	27	1	1
Sartika Puji Astuti	Bogor	26 September 1995	P	sunda	1	K1	Jl. Sempur Kaler Blok II /1 RT 05 RW 01 Kel. Sempur Kec. Kota Bogor Tengah Kota Bogor	\N	\N	\N	3201046609950002	\N	081218440339	sartikafujiastuti@gmail.com	\N	Bernyayi	703640870403000	\N	BCA	2020-10-13 03:17:19	2021-04-16 07:41:41	28	1	1
Agus Setiawan	Soreang	13 Desember 1988	L	sunda	1	BK	Kp. Bojong Citeupus Rt 06 /09 Kel. Cangkuang Wetan Kec. Dayeuhkolot Kab. Bandung	\N	\N	3204123005110114	3204121312880008	\N	081221181026	setiawanagusrf8891@gmail.com	Kp. Bojong Citeupus Rt 06 /09 Kel. Cangkuang Wetan Kec. Dayeuhkolot Kab. Bandung	\N	771180379445000	7380544983	BCA	2020-10-13 03:06:26	2021-04-16 07:42:57	21	1	1
Nina Marlina	Karawang	15 Maret 1986	P	sunda	1	BK	Cimanglid Gg. H. Milo Rt 03/12 Kel. Sirnagalih Kec. Tamansari Kabupaten Bogor	\N	\N	3201310708080006	3201315503860001	\N	081386925009	amaruynha00.an@gmail.com	Cimanglid Gg. H. Milo Rt 03/12 Kel. Sirnagalih Kec. Tamansari Kabupaten Bogor	\N	664588977434000	0953437055	BCA	2020-10-13 03:04:17	2021-04-16 07:43:46	20	1	1
Ir. Eko Wiyantono	Jember	26 Oktober 1964	L	jawa	1	K	Jl. Anggrek Bulan No.9 RT 02 RW 09 Kel. Jatimulyo Kec. Lowok Waru Kota Malang	\N	\N	\N	3573052610640001	\N	082210092838	wiyantono71@yahoo.com	\N	\N	252867155401000	7360412827	BCA	2020-10-13 03:46:20	2021-04-15 08:07:09	40	1	1
Jeffry Alvianto	Yogyakarta	07 Juli 1997	L	jawa	1	BK	Kp. Tanah Sewa RT 05 RW 03 Kel. Ciparigi Kec. Kota Bogor Utara, Kota Bogor	16157	\N	3271052602074629	3271050707970008	\N	08978647866	jeffryalvian@gmail.com	Kp. Tanah Sewa RT 05 RW 03 Kel. Ciparigi Kec. Kota Bogor Utara, Kota Bogor	olah raga	734401219404000	8410993164	BCA	2020-10-13 04:05:08	2021-04-16 06:51:07	52	1	1
Aoedronick Todo P. Siagian ST	Cimahi	30 April 1984	L	batak	2	K1	Kav. DPRD  DKI BLK H21 RT 11 RW 07 Kel Cibubur Kec. Ciracas Jakarta Timur	\N	\N	3175092502151016	3175093004840005	\N	088210381050	aoedronick@gmail.com	Kav. DPRD  DKI BLK H21 RT 11 RW 07 Kel Cibubur Kec. Ciracas Jakarta Timur	travelling	249158221009000	8410422787	BCA	2020-10-13 03:33:25	2021-04-16 06:52:15	34	1	1
Wildan Awaludin	Bogor	15 September 1993	L	sunda	1	K1	Kp. Sirnagalih RT 02 RW 03 Kel. Ranggamekar Kec. Kota Bogor Selatan Kota Bogor	\N	\N	\N	3271011509930010	\N	085716390134	wildanawaludin23@gmail.com	Kp. Sirnagalih RT 02 RW 03 Kel. Ranggamekar Kec. Kota Bogor Selatan Kota Bogor	Bermain Bola	tidak punya	4270131714	BCA	2020-10-13 03:35:42	2021-04-16 06:53:32	36	1	1
M. Alit Sanusi	Bogor	17 November 1972	L	sunda	1	K2	Kaum Sari Rt 02 Rw 05 Kel. Cibuluh Kec. Kota Bogor Utara, Kota Bogor	16151	\N	3271050403071792	3271051711720001	\N	087770555093	albysanusi73@gmail.com	Kaum Sari Rt 02 Rw 05 Kel. Cibuluh Kec. Kota Bogor Utara, Kota Bogor	\N	686744186404000	8720310849	BCA	2020-10-13 04:03:47	2021-04-16 07:00:30	51	1	1
Ivan Andrian	Bogor	16 November 1990	L	\N	1	K1	Gg. Kembang RT 04 RW 09 Kel. Kedunghalang Kec. Kota Bogor Utara Kota Bogor	\N	\N	\N	3271051611900002	\N	085694398705	\N	Gg. Kembang RT 04 RW 09 Kel. Kedunghalang Kec. Kota Bogor Utara Kota Bogor	Futsal	731386876404000	8411010473	BCA	2020-10-13 04:01:08	2021-04-16 07:02:07	49	1	1
Muchlis	Bogor	07 September 1995	L	betawi	1	BK	Kp. Sudimampir RT 04 RW 02 Kel. Cimanggis Kec. Bojong Gede Kab Bogor	\N	\N	\N	3201130709950004	\N	0895355620027	muchlishadhiding599@gmail.com	Kp. Sudimampir RT 04 RW 02 Kel. Cimanggis Kec. Bojong Gede Kab Bogor	Olah Raga	\N	8720459150	BCA	2020-10-13 03:38:42	2021-04-16 07:04:23	37	1	1
Mega Nur Fitria	Bogor	27 Agustus 2000	P	sunda	1	BK	Cijujung Tengah RT 04 / 04 Kel. Cijujung Kec. Sukaraja Kabupaten Bogor	16710	\N	3201042901070028	3201046708000008	\N	088290440016	nurfitriamega27@gmail.com	Cijujung Tengah RT 04 / 04 Kel. Cijujung Kec. Sukaraja Kabupaten Bogor	Menggambar	\N	8410406471	BCA	2020-10-13 03:58:34	2021-04-16 07:07:46	47	1	1
Rahmat Kusnanto	Bogor	26 November 1974	L	sunda	1	K2	Sampora RT 05 RW 03 Kel. Cibinong Kec. Cibinong Kab. Bogor	\N	\N	\N	3201012611740002	\N	\N	\N	Sampora RT 05 RW 03 Kel. Cibinong Kec. Cibinong Kab. Bogor	\N	\N	6830590658	BCA	2020-10-13 03:47:41	2021-04-16 07:16:43	41	1	1
Sumarta	Bogor	02 Februari 1958	L	sunda	1	K3	Kp. Pangkalan RT 01 RW 01 Kel. Cibuluh Kec. Kota Bogor Utara Kota Bogor	\N	\N	\N	3271050202580012	\N	\N	\N	\N	\N	\N	8410485533	BCA	2020-10-13 03:51:09	2021-04-16 07:21:10	43	1	1
Lukman Nulhakim	Bogor	11 Januari 1980	L	sunda	1	BK	Kp. Kaum Sari RT 03 RW 05 Kel. Cibuluh Kec. Kota Bogor Utara Kota Bogor	\N	\N	\N	3271051101800017	\N	085715672530	\N	Kp. Kaum Sari RT 03 RW 05 Kel. Cibuluh Kec. Kota Bogor Utara Kota Bogor	\N	\N	8410485410	BCA	2020-10-13 03:55:37	2021-04-16 07:21:42	46	1	1
Ryan Andresta Wiguna	Tangerang	16 November 1991	L	betawi	1	K	Jl. Prenja No.17 RT 09 RW 01 Kel. Bukit Duri Kec. Tebet , Jakarta Selatan	\N	\N	\N	3174011611910008	\N	087882842568	ryan.andresta@gmail.com	Jl. Prenja No.17 RT 09 RW 01 Kel. Bukit Duri Kec. Tebet , Jakarta Selatan	Futsal	755474889015000	7380617174	BCA	2020-10-13 03:52:22	2021-04-16 07:29:08	44	1	1
Sunardi	Wonogiri	19 Juli 1981	L	jawa	1	K1	Pondok Ungu Permai Blok C 15 RT 15 RW 10 Kel. Kaliabang Tengah Kec. Bekasi Utara Kota Bekasi	\N	\N	\N	3275031907810021	\N	08122645238	sunardi190781@gmail.com	Pondok Ungu Permai Blok C 15 RT 15 RW 10 Kel. Kaliabang Tengah Kec. Bekasi Utara Kota Bekasi	olah raga	359050267407000	8410477913	BCA	2020-10-13 04:11:49	2021-04-16 07:29:45	56	1	1
Ardian Hary Sudarto	Bogor	05 Mei 1997	L	jawa	1	BK	Jl. MT. Haryono No. 58 RT 17 RW 06 Kel. SumberGedong Kec. Trenggalek Kab. Trenggalek	66315	\N	3503110907090001	3503110505970004	\N	082232249793	ardianhary@gmail.com	Taman Tampak Siring IX No. 29 Sentul City	Olah Raga	tidak punya	1131246132	BCA	2020-10-13 03:31:39	2021-04-16 07:30:10	33	1	1
Rendy Dwi Putra	Jakarta	02 Mei 1997	L	sunda	1	BK	Jl. Pamoyanan Sari RT 03 RW 01 Kel. Ranggamekar Kec. Kota Bogor Selatan Kota Bogor	\N	\N	3271010204120008	3271010205970019	\N	087770298902	rendydwiputra70@gmail.com	Jl. Pamoyanan Sari RT 03 RW 01 Kel. Ranggamekar Kec. Kota Bogor Selatan Kota Bogor	Design	923347165404000	7600510031	BCA	2020-10-13 04:02:23	2021-04-16 07:36:23	50	1	1
Marini	Yogyakarta	30 Juni 1981	P	jawa	1	K2	Bukit Cimanggu City Blok U 2/2 RT 05 RW 14 Kel. Cibadak Kec. Tanah Sareal Kota Bogor	16166	\N	3271061109090021	3271067006810015	\N	081218806999	riniharyanto@yahoo.co.id	Bukit Cimanggu City Blok U 2/2 RT 05 RW 14 Kel. Cibadak Kec. Tanah Sareal Kota Bogor	olah raga	892678053404000	1661907491	BCA	2020-10-13 04:08:35	2021-04-16 07:39:47	55	1	1
Bepin Zahari	Muara Pulutan	12 Juni 1994	L	\N	1	BK	Perum Vila Asri 2 blok P 23 RT 02 RW 25 Kel. Wanaherang Kec. Gunung Putri Kab. Bogor	\N	\N	\N	1701021206940002	\N	081318440300	bpinzahari@gmail.com	Jl. Bababkan Madang  Sentul Bogor	olah raga	914067434403000	\N	BCA	2020-10-13 04:07:36	2021-04-16 07:42:20	54	1	1
M. Rizki Maulana	Bogor	06 September 1992	L	sunda	1	K	Perum Puspa Raya Blok FA/18 RT 02 RW 09 Kel. BojongBaru Kec. Bojong Gede Kab. Bogor	\N	\N	\N	3201130609920005	\N	081292624513	muhammadrizky.property@gmail.com	\N	olah raga	660689407403000	\N	BCA	2020-10-13 04:06:25	2021-04-16 07:44:44	53	1	1
Suci Fitriyanto	Jakarta	05 Juni 1986	L	jawa	1	BK	Perumahan Citra Graha Prima Jl. Rajawali 2 BLO RT 001 RW 013 Kel. Singasari Kec. Jonggol Kab. Bogor	\N	\N	3201060303170003	3172040506860001	\N	081283153040	sucifitriyanto@gmail.com	Perum Citra Graha Prima, Blok R.38-26 RT 001/013	Olah Raga	BCA	\N	4061085453	2020-10-13 04:24:15	2021-04-15 08:07:16	61	1	1
Hendrik Indra	Medan	22 Agustus 1974	L	tapanuli	12	K4	Kp. Biru No. 237 Rt 002/ 004 Kel. Dago Kec. Coblong Kota Bandung	\N	\N	\N	3273022208740012	\N	081808033714	peiterjoh@gmail.com	Jl. Pangeran Antasari No 36 Jakarta Selatan	\N	574908737423000	6220328412	BCA	2020-10-13 04:43:25	2021-04-16 06:51:32	74	1	1
Adhithia Sigit Purwono	Jakarta	26 November 1993	L	jawa	1	BK	Perum Griya Curug C 5/15 Rt 10 Rw 11 Kel. Rancagong Kec. Legok, Kabupaten Tangerang	15920	\N	3603202109150006	3603172611930004	0215986711	087782515351	sigitadhithia@gmail.com	Perum Griya Curug C 5/15 Rt 10 Rw 11 Kel. Rancagong Kec. Legok, Kabupaten Tangerang	Main Game	722482726451000	0953763556	BCA	2020-10-13 04:39:17	2021-04-16 06:52:40	70	1	1
Putri Permatasari	Bogor	18 November 1993	P	sunda	1	BK	Lingkungan 01 Ciriung RT 04 RW 03 Kel. Ciriung Kec. Cibinong Kab. Bogor	16917	\N	3201011907074123	3201015811930007	\N	085606182649	putripermatasari1818@gmail.com	Lingkungan 01 Ciriung RT 04 RW 03 Kel. Ciriung Kec. Cibinong Kab. Bogor	Membaca	842607723403000	6830583163	BCA	2020-10-13 04:13:25	2021-04-16 06:57:28	57	1	1
Sofyan Akbar Supni Komara	Tasikmalaya	16 September 1998	L	sunda	1	BK	Cibuluh Rt 001/008 Kel. Cibuluh Kec. Kota Bogor Utara, Kota Bogor	\N	\N	3271050203072525	3271051609980002	\N	0895603025221	sofyanakbar39@gmail.com	Cibuluh Rt 001/008 Kel. Cibuluh Kec. Kota Bogor Utara, Kota Bogor	Olah Raga	tidak punya	0953763637	BCA	2020-10-13 04:45:32	2021-04-16 07:01:18	76	1	1
Ahmad Fauzi Mulyadi	Cianjur	12 April 1994	L	sunda	1	BK	Gg. Bali RT 01 RW 16 Kel. Bojong Herang Kec. Cianjur Kab. Cianjur	43216	\N	3203011511130001	3203011204940020	\N	081296916858	ajidot063@gmail.com	Gg. Bali RT 01 RW 16 Kel. Bojong Herang Kec. Cianjur Kab. Cianjur	Olah Raga	\N	0954081008	BCA	2020-10-13 04:20:33	2021-04-16 07:02:28	60	1	1
Wawan Sugianto	Tegal	11 Juli 1979	L	jawa	1	K3	Dk. Karangsari Rt 03/05 Kel.Sukomulyo Kec. Rowokele Kab. Kebumen	54472	\N	3305171505100002	3305171107790001	\N	087855099816	wawansugianto39@gmai.com	Dk. Karangsari Rt 03/05 Kel.Sukomulyo Kec. Rowokele Kab. Kebumen	Memancing	\N	5005234520	BCA	2020-10-13 04:26:12	2021-04-16 07:02:56	63	1	1
Ahmad Nawawi	Bogor	08 Oktober 1979	L	sunda	1	K2	Kp. Cibuluh RT 04 RW 08 Kel. Cibuluh Kec. Kota Boogor Utara Kota Bogor	\N	\N	3271052907080056	3271050810790024	\N	085691983050	\N	\N	Olah Raga	\N	8410487943	BCA	2020-10-13 04:25:16	2021-04-16 07:14:20	62	1	1
Farhan Jamil	Bogor	12 April 1989	L	sunda	1	K2	Kp. Kaum Sari RT 02 RW 05 Kel. Cibuluh Kec. Kota Bogor Utara Kota Bogor	16151	\N	\N	3271061204890004	\N	085781366478	jamilfarhan862@gmail.com	Kp. Kaum Sari RT 02 RW 05 Kel. Cibuluh Kec. Kota Bogor Utara Kota Bogor	Olahraga	\N	8410484871	BCA	2020-10-13 04:16:35	2021-04-16 07:22:25	58	1	1
Ridwan	Sukabumi	01 Agustus 1991	L	sunda	1	K1	Kp. Blok Randu RT 01 RW 03 Kel. Darmareja Kec. Nagrak Kab. Sukabumi	\N	\N	\N	3202120108910007	\N	\N	\N	\N	\N	\N	3520606296	BCA	2020-10-13 04:18:05	2021-04-16 07:23:18	59	1	1
Nurwanto	Banjarnegara	19 Januari 1981	L	jawa	2	K2	Bogor Asri Blok K8-5  Rt 06 / 11 Kel. Nanggewer Kec. Cibinong	\N	\N	\N	3304091901810001	\N	081287984131	brewqclodias@gmail.com	Bogor Asri Blok K8-5  Rt 06 / 11 Kel. Nanggewer Kec. Cibinong	Olah Raga	758724173403000	0953763424	BCA	2020-10-13 04:35:12	2021-04-16 07:28:34	66	1	1
Meilyana	Jakarta	02 Mei 1973	P	jawa	12	C3	Perum Cenning Ampe Blok M No.1 RT 04 RW 27 Kel. Sukamaju Kec. Cilodong Kota Depok	16415	\N	3276050602080026	3276054205730006	\N	08111111781	meil_yana@ymail.com	Perum Cenning Ampe Blok M No.1 RT 04 RW 27 Kel. Sukamaju Kec. Cilodong Kota Depok	Olah Raga	672422607412000	6460173033	BCA	2020-10-13 04:42:29	2021-04-16 07:34:26	73	1	1
Enjang Misbah	Tasikmalaya	15 Desember 1975	L	sunda	1	K3	Jl. Batutulis Gg. Balekambang No.113 Rt 001 Rw 004 Kel. Batutulis Kec. Kota Bogor Selatan	\N	\N	\N	3271011512750003	\N	081398826575	enjangmisbah@gmail.com	Jl. Batutulis Gg. Balekambang No.113 Rt 001 Rw 004 Kel. Batutulis Kec. Kota Bogor Selatan	Traveling	681824728404000	8410253811	BCA	2020-10-13 04:27:11	2021-04-16 07:35:01	64	1	1
Asep Saepulloh	Bogor	09 September 1989	L	sunda	1	BK	Jl. Parung Banteng Rt 01 Rw 02 Kel. Katulampa Kec. Bogor Timur Kota Bogor	16710	\N	3271020403070325	3271020909890014	\N	081281266286	asepsaepulloh.056@gmail.com	Jl. Parung Banteng Rt 01 Rw 02 Kel. Katulampa Kec. Bogor Timur Kota Bogor	Olahraga,Game	794235663404000	0953637364	BCA	2020-10-13 04:43:39	2021-04-16 07:37:19	75	1	1
Arip Rahman Hidayat	Bogor	02 Mei 1996	L	sunda	1	K1	Sindangbarang RT 05 RW 01 Kel. Sindangbarang Kec. Kota Bogor Barat	16117	\N	3271040412180015	3271040204960002	\N	0895355288199 / 0895350288739	\N	Sindangbarang RT 05 RW 01 Kel. Sindangbarang Kec. Kota Bogor Barat	Sepak Bola	\N	6820870776	BCA	2020-10-13 04:28:03	2021-04-16 07:37:52	65	1	1
Theodore David P.S	Sawah Lunto	25 Juni 1980	L	batak	12	K3	Jl. Cawang Gg. Tauladan RT 07 RW 12 Kel. Bidara Cina Kec. Jatinegara Jakarta Timur	\N	\N	3175030205121003	3603282506800010	087777786586	081585959525	theodavid.3m@gmail.com	Pesona Calgary UF 4 Kota Wisata Cibubur	Olah Raga	254421225451000	\N	BCA	2020-10-13 04:41:29	2021-04-16 07:39:00	72	1	1
Muhamad Noor	Sukoharjo	16 April 1989	L	jawa	1	K2	Sindang Barang Jero no. 1 RT 06 / RW 07 Kel. SindangBarang Kec. Kota Bogor Barat	\N	\N	\N	3171010604890005	\N	087822571999	noerrifky@gmail.com	Sindang Barang Jero no. 1 RT 06 / RW 07 Kel. SindangBarang Kec. Kota Bogor Barat	Olah Raga	719087157028000	\N	BCA	2020-10-13 04:38:10	2021-04-16 07:41:06	69	1	1
Muhamad Satya	Bogor	10 Desember 1983	L	sunda	1	K2	Kp. Cikereteg Rt 01 / Rw 04 Kel. Ciderum Kec. Caringin, Kota Bogor	\N	\N	\N	3201271012830007	\N	085710651114	satyamuhamad@gmail.com	Kp. Cikereteg Rt 01 / Rw 04 Kel. Ciderum Kec. Caringin, Kota Bogor	Olah Raga	784572935434000	0953275527	BCA	2020-10-15 06:56:14	2020-10-15 06:56:14	96	1	\N
Marco Hagai Oscar Lontoh	Balikpapan	28 Juni 1989	L	\N	12	BK	Jl. Kol. Syarifuddin Yoes no. 07 RT 094 RW - Kel. Sepinggan Kec. Balikpapan Selatan Kota Balikpapan	\N	\N	6471052806890003	6471052806890003	\N	081253289228	marcolontoh777@gmail.com	Metro Residence Cluster Pine wood Blok B3 No 9 Cibinong	Olah Raga	158353540721000	7135039292	BCA	2021-03-23 03:02:51	2021-03-23 03:02:51	103	1	\N
Novan Abdilah Agilyansyah	Bogor	06 November 1992	L	sunda	1	K	Kp. Bongas 3 RT 02 RW 09 Kel. Kalongliud Kec. Nanggung Kab. Bogor	16650	1603771000ocbd2.jpg	\N	3672050611920002	\N	081288650512	novanokkey@gmail.com	Kp. Bongas 3 RT 02 RW 09 Kel. Kalongliud Kec. Nanggung Kab. Bogor	makan	732223235434000	\N	BCA	2020-10-13 06:40:39	2021-03-10 03:02:10	94	1	1
Prasetiawan G.S	Bogor	24 November 1986	L	sunda	1	K2	Bukit Mekar Wangi Blok C 13 NO 19 RT 04 RW 05 Kel. Mekarwangi Kec. Tanah Sareal Kota Bogor	16166	1606376359IMG_2585 copy.jpg	3271060406180007	3271022411860006	\N	081314162222, 081-1111-1186	hr.admin@olympic-development.com	Bukit Mekar Wangi Blok C 13 NO 19 RT 04 RW 05 Kel. Mekarwangi Kec. Tanah Sareal Kota Bogor	Traveling	892245259404000	0953757611	BCA	2020-10-13 02:49:27	2021-03-10 08:23:07	16	1	1
Burhannudin	Bogor	06 Maret 1995	L	sunda	1	BK	Sampora RT 01 RW 01 Nanggewer Mekar Kel. Cibinong Kab Bogor	\N	\N	\N	3201010603951002	\N	085694010656	Burhannudinmbuyy@gmail.com	Sampora RT 01 RW 01 Nanggewer Mekar Kel. Cibinong Kab Bogor	Olah Raga	\N	8410486050	BCA	2020-10-13 03:39:56	2021-04-16 07:11:30	38	1	1
Alfarisi	Bogor	25 April 1996	L	sunda	1	BK	Sindang Sari Rt 01 Rw 11 Kel. Tanah Baru Kec. Kota Bogor Utara Kab. Bogor	16154	\N	3271052706130013	3271052504960011	\N	08995912396	\N	Sindang Sari Rt 01 Rw 11 Kel. Tanah Baru Kec. Kota Bogor Utara Kab. Bogor	Menggambar	\N	8410478456	BCA	2020-10-13 06:21:44	2021-04-16 07:15:02	81	1	1
Muhamad Ramdani	Bogor	20 Desember 1997	L	sunda	1	BK	Kp. Cikeas RT 01 / 10 Ds Bojong Koneng, Kec. Babakan Madang Kab. Bogor	\N	\N	\N	3201052712970001	\N	085782150148/085691204680	ramdanimuhamad863@gmail.com	Kp. Cikeas RT 01 / 10 Ds Bojong Koneng, Kec. Babakan Madang Kab. Bogor	Olah Raga	\N	\N	BCA	2020-10-13 06:27:03	2021-04-16 07:15:38	83	1	1
Dedi Anggoro	Semarang	06 Januari 1988	L	jawa	1	K2	Basen KG.III/296 RT 15 RW 04 Kel. Purbayan Kec. Kotagede Kota Yogyakarta	\N	\N	\N	3374060601880002	\N	085866334673	dedi.anggoro.da@gmail.com	Jl. Puri Dinar Mas XIV no 7	Olah Raga	984082156517000	\N	BCA	2020-10-13 06:36:26	2021-04-16 07:16:04	90	1	1
Muhamad Ibnu Maulana	Bogor	27 Mei 1997	L	sunda	1	K1	Jl. Pesantren No. 19 RT 02/06 Kel. Kedunghalang Kec. Bogor Utara Kota Bogor	\N	\N	\N	3271052705970012	\N	087870901989	mibnu2705@gmail.com	Jl. Pesantren No. 19 RT 02/06 Kel. Kedunghalang Kec. Bogor Utara Kota Bogor	Olah Raga	809638398404000	\N	BCA	2020-10-13 06:28:22	2021-04-16 07:23:54	84	1	1
Andika Maulana Akbar	Bogor	20 Mei 2002	L	sunda	1	BK	Muara Beres RT 02 RW 04 Kel. Sukahati Kec. Cibinong Kab. Bogor	\N	\N	\N	3201012005020008	\N	0895352093939	maulanadika407@gmaial.com	Muara Beres RT 02 RW 04 Kel. Sukahati Kec. Cibinong Kab. Bogor	Olah Raga	\N	\N	\N	2020-10-13 06:41:37	2021-04-16 07:24:35	95	1	1
Ir Zakaria Antomi	Air Molek	17 Mei 1967	L	melayu	1	K2	Perum Taman Sentosa B J6 No 12A Rt 15/06 Kel. Sukaresmi Kec. Cikarang Selatan Kab. Bekasi	\N	\N	\N	3216191705670004	\N	081398336057	zakaria.antomi@yahoo.co.id	Perum Taman Sentosa B J6 No 12A Rt 15/06 Kel. Sukaresmi Kec. Cikarang Selatan Kab. Bekasi	Olah Raga	688388073413000	5980107461	BCA	2020-10-13 06:19:21	2021-04-16 07:25:40	80	1	1
Firmansyah	Jakarta	10 Mei 1988	L	\N	1	K1	Dasana Indah SC.6/31 Kelapa dua Tanggerang	\N	\N	3671051005880006	3671051005880006	\N	087770562066	yth.firmansyah@gmail.com	Jl. Parung Banteng RT 02 RW 01 No 80 Kel. Katulampa Kec. Bogor Timur Kota Bogor	Olah Raga	805861911452000	8015328751	BCA	2021-03-23 03:09:05	2021-03-23 03:09:05	105	1	\N
Donny Rinaldy	Bogor	22 Mei 1980	L	sunda	1	K3	Jl. Panaragan Pojok RT 03 RW 07 Panaragan Bogor	16125	\N	3271032205800005	3271032205800005	\N	081288282575	donnyrinaldy22@gmail.com	Jl. Panaragan Pojok RT 03 RW 07 Panaragan Bogor	Olah Raga	690269410404000	0953038916	BCA	2021-03-23 03:16:18	2021-03-23 03:16:18	106	1	\N
Nashrudin	Pandeglang	09 Januari 1983	L	sunda	1	K2	Babakan Fakultas RT 001 RW 004 Kel. Tegal Lega Kec. Kota Bogor Tengah Kota Bogor	\N	\N	3271030901830008	3271030901830008	\N	081213638778	nashrudin.83master@gmail.com	Babakan Fakultas RT 001 RW 004 Kel. Tegal Lega Kec. Kota Bogor Tengah Kota Bogor	Olah Raga	598583623404000	8720250412	BCA	2021-03-23 03:18:05	2021-03-23 03:18:43	107	1	\N
Wilfan Shofa	Kebumen	12 April 1997	L	jawa	1	BK	Kp.Bojong Neros RT 003 RW 007 Kel. Curug Kec. Kota Bogor Barat Kota Bogor	16113	\N	3271042302074261	3271041204970005	\N	088219614329	wilfanshofa23@gmail.com	Kp.Bojong Neros RT 003 RW 007 Kel. Curug Kec. Kota Bogor Barat Kota Bogor	Olah Raga	927732602404000	8720359953	BCA	2021-03-23 03:20:56	2021-03-23 03:20:56	108	1	\N
Widya Kadarusman	Bandung	18 Januari 1987	P	sunda	1	K1	Jl. Griya Indah G 04 No 16 RT 003 RW  007 Kel. Ciomas Rahayu Kec. Ciomas Kab. Bogor	16610	\N	3201295801870001	3201295801870001	\N	081287596488	widyakadarusman65@gmail.com	Jl. Laladon Baru IV RT 005 RW 001	Olah Raga	730345303428000	0952658741	BCA	2021-03-23 03:23:34	2021-03-23 03:23:34	109	1	\N
Muhamad Gojali	Bogor	28 November 1984	L	sunda	1	K1	Kaum Sari Rt 01 Rw 05 Kel. Cibuluh Kec. Kota Bogor Utara, Kota Bogor	\N	\N	3271052811840005	3271052811840005	\N	081514220569	m.gojali84@gmail.com	Kaum Sari Rt 01 Rw 05 Kel. Cibuluh Kec. Kota Bogor Utara, Kota Bogor	Olah Raga	TIDAK PUNYA	8410564301	BCA	2021-03-23 03:26:18	2021-03-23 03:26:18	110	1	\N
Madison Lyman	Jakarta	04 Oktober 1999	L	\N	12	BK	Jl. STR Karya Selatan Blok c.3/16 RT 001 RW 013 Kel. Sunter Agung Kec. Tanjung Priok	\N	\N	3172020410990006	3172020410990006	\N	087888651511	madisonlyman.ce@gmail.com	Jl. STR Karya Selatan Blok c.3/16 RT 001 RW 013 Kel. Sunter Agung Kec. Tanjung Priok	Olah Raga	TIDAK PUNYA	0083508385	BCA	2021-03-23 03:28:20	2021-03-23 03:28:20	111	1	\N
Nabila Sekar Ayu	Bogor	22 September 1998	P	sunda	1	BK	"Kp. Situpete RT 001 RW 008 Kel. Sukadamai\r\n  Kec. Tanah Sareal Kota Bogor"	16165	\N	3271060303075870	3271066209980006	\N	089630320653	nabilasekar12@gmail.com	"Kp. Situpete RT 001 RW 008 Kel. Sukadamai\r\n  Kec. Tanah Sareal Kota Bogor"	Olah Raga	TIDAK PUNYA	8720395216	BCA	2021-03-10 05:39:44	2021-03-23 08:28:34	102	1	\N
Yannes Pasaribu	Jakarta	19 Januari 1969	L	\N	12	K3	Jl Cidodol Raya Komp Loka Permai No1-2 Rt 010/ 006 Kel Grogol Selatan Kec Kebayoran Lama Kota Jakarta Selatan	\N	1606378940_MG_1088 copy.jpg	3174051602100033	3171041901690005	\N	081399091172	\N	Jl Cidodol Raya Komp Loka Permai No1-2 Rt 010/ 006 Kel Grogol Selatan Kec Kebayoran Lama Kota Jakarta Selatan	\N	\N	6770052279	BCA	2020-10-13 02:37:33	2021-04-15 08:02:53	11	1	1
Sandro Marcelino Damanik	Palembang	21 September 1983	L	batak	3	K	Jl. Sonokeling Raya No. 179 A Rt 04/15 Kel. Baktijaya Kec. Sukmajaya Kota Depok	16418	\N	3276052508100012	3276052109830007	\N	081369004602	mandromarcelino@yahoo.com	Vila Bogor Indah 3 Blok Ab2/14, Rt 06/15 Kel. Kedung Halang Kec. Bogor Utara Kota Bogor	Membaca	256833724412000	0953762959	BCA	2020-10-13 02:55:06	2021-04-15 08:03:22	18	1	1
Dwi Wulandari	Bogor	16 Mei 1986	P	jawa	3	K2	Jl Kamboja 2 No 03 Rt 07/ 05 Cimanggis Depok	16951	\N	3276020410110050	3276025605860009	\N	081213396461, (WA 081283295086)	\N	Jl Kamboja 2 No 03 Rt 07/ 05 Cimanggis Depok	Traveling	585910102412000	5240314136	BCA	2020-10-13 04:40:22	2021-04-15 08:06:49	71	1	1
Dina Arsitarely	Bogor	26 Juni 1996	P	jawa	1	BK	Puri Nirwana 1 blok K no. 30 RT 03 RW 16 Kel. Pabuaran Kec. Cibinong Kab. Bogor	16913	\N	3201012808070134	3201016606960005	\N	089534617633	dinaarsitarely@yahoo.com	Puri Nirwana 3 blok AE no. 1 RT 08 RW 14 Kel. Sukahati Kec. Karadenan Kab. Bogor	Travel	842242265403000	1671304522	BCA	2020-10-13 03:41:11	2021-04-15 08:07:02	39	1	1
Yohanes Sumarno	Surabaya	04 Juli 1963	L	\N	12	K2	JL. PANGRANGO I BLOK 2/12, BEKASI SELATAN	0	\N	3275042409140005	3275040407630025	\N	081213260036	\N	\N	\N	0	\N	\N	2021-04-16 07:52:34	2021-04-16 07:52:34	112	1	\N
Zakki Mubarok	0	0	L	jawa	1	BK	\N	\N	\N	0	0	\N	\N	\N	\N	\N	0	\N	\N	2021-04-29 09:06:51	2021-04-29 09:06:51	113	1	\N
Dwi Anggita Permana	\N	\N	P	\N	1	BK	\N	\N	\N	0	0	\N	\N	\N	\N	\N	0	\N	\N	2021-04-29 09:09:07	2021-04-29 09:09:07	114	1	\N
Andre Hendra Gunadi	\N	\N	L	jawa	1	BK	\N	\N	\N	0	0	\N	\N	\N	\N	\N	0	\N	\N	2021-04-29 09:11:33	2021-04-29 09:11:44	115	1	\N
\.


--
-- TOC entry 3078 (class 0 OID 53724)
-- Dependencies: 214
-- Data for Name: tabel_kategori_absen; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_kategori_absen (id_kategori_absen, kode, created_at, updated_at, keterangan, konsekuensi) FROM stdin;
1	PC	\N	\N	PULANG CEPAT	<= SETENGAH HARI POTONG GAJI 1/2 HARI
2	L	\N	\N	LEMBUR	>= 1 JAM DIHITUNG LEMBUR
3	T	\N	\N	TERLAMBAT .= 1 MENIT	>= SETENGAH HARI POTONG GAJI 1/2 HARI
4	S	\N	\N	SAKIT TANPA SURAT DOKTER	POTONG GAJI
9	I	\N	\N	MASUK	\N
11	TM	2021-03-31 09:01:51	2021-03-31 09:01:51	tidak masuk belum ada keterangan	\N
\.


--
-- TOC entry 3092 (class 0 OID 53819)
-- Dependencies: 228
-- Data for Name: tabel_lembur; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_lembur (id_lembur, no_dok, created_at, updated_at, hari, tgl_pengajuan, tgl_lembur, kegiatan, atasan1, atasan2, catatan, jam_mulai, jam_akhir, total_jam, um, id_karyawan_personal, status_pengajuan, alasan_tolak) FROM stdin;
9	\N	2021-04-08 15:20:44	2021-04-08 15:22:29	Kamis	2021-04-08	2021-04-08	pasang kabel	31	10	jangan lembur dulu	18:00:00	22:00:00	14400	\N	94	3	ganti hari
10	\N	2021-04-08 15:23:50	2021-05-04 13:49:55	Kamis	2021-04-08	2021-04-08	pasang kabel	31	10	tolong dimaksimalkan	19:00:00	23:00:00	14400	\N	94	2	ok
7	\N	2021-04-07 10:41:35	2021-05-04 13:50:09	Sabtu	2021-04-07	2021-04-10	upgrade server	31	10	untuk pemasangan diusahakan harus selesai segera	18:00:00	22:30:00	16200	\N	94	2	ok
5	\N	2021-04-07 10:40:33	2021-05-04 13:50:13	Senin	2021-04-07	2021-04-05	pasang kabel	31	10	ok lanjutkan sebaik baiknya	18:00:00	20:00:00	7200	\N	94	2	ok
6	\N	2021-04-07 10:41:22	2021-05-04 13:50:15	Kamis	2021-04-07	2021-04-08	upgrade server impro	31	10	untuk pemasangan diusahakan harus selesai segera	17:00:00	21:00:00	14400	\N	94	2	ok
8	\N	2021-04-07 11:07:18	2021-05-04 13:50:18	Jumat	2021-04-07	2021-04-30	pasang kabel	31	10	untuk pemasangan diusahakan harus selesai segera	18:00:00	23:00:00	18000	\N	94	2	ok
\.


--
-- TOC entry 3112 (class 0 OID 54086)
-- Dependencies: 248
-- Data for Name: tabel_level; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_level (id_level, level, created_at, updated_at) FROM stdin;
1	DIR	\N	\N
3	GM	2020-10-06 06:28:37	2020-10-13 02:05:26
4	MGR	2020-10-06 06:28:44	2020-10-13 02:05:29
6	OPR	2020-10-06 06:29:13	2020-10-13 02:05:38
7	SENIOR STAFF	2020-10-06 06:29:19	2020-10-13 02:05:55
10	SPV	2020-10-13 02:06:03	2020-10-13 02:06:03
11	STAFF	2020-10-13 02:06:10	2020-10-13 02:06:10
\.


--
-- TOC entry 3099 (class 0 OID 53931)
-- Dependencies: 235
-- Data for Name: tabel_log_absen; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_log_absen (created_at, updated_at, pin, id_karyawan_personal, checktime, checktype, alatabsen, row_id) FROM stdin;
\N	\N	305	\N	2021-05-06 09:00:54	4	Mesin 1	6859
\N	\N	305	\N	2021-05-06 09:00:56	4	Mesin 1	6860
\N	\N	348	\N	2021-05-06 09:02:05	0	Mesin 1	6861
\N	\N	377	\N	2021-05-06 09:04:05	0	Mesin 1	6863
\N	\N	370	\N	2021-05-06 09:04:11	0	Mesin 1	6864
\N	\N	261	\N	2021-05-06 09:05:43	4	Mesin 1	6865
\N	\N	234	\N	2021-05-06 09:19:37	4	Mesin 1	6866
\N	\N	350	\N	2021-05-06 09:21:02	4	Mesin 1	6867
\N	\N	209	\N	2021-05-06 09:51:12	4	Mesin 1	6869
\N	\N	397	\N	2021-05-06 11:05:42	4	Mesin 1	6870
\.


--
-- TOC entry 3090 (class 0 OID 53808)
-- Dependencies: 226
-- Data for Name: tabel_perjalanan_detail; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_perjalanan_detail (id_penugasan_karyawan, id_perjalan, created_at, updated_at, npk, nama_karyawan, jabatan, departemen) FROM stdin;
\.


--
-- TOC entry 3088 (class 0 OID 53783)
-- Dependencies: 224
-- Data for Name: tabel_perjalanan_dinas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_perjalanan_dinas (id_penugasan, created_at, updated_at, tgl_mulai, tgl_akhir, tujuan, person_dituju, uraian_tugas, transportasi_perhari, transportasi_jumlah, transportasi_keterangan, status_pengajuan, akomodasi_perhari, akomodasi_jumlah, akomodasi_keterangan, tm_perhari, tm_jumlah, tm_keterangan, lain_perhari, lain_jumlah, lain_keterangan, tgl_pengajuan, pemohon, ditugaskan, disetujui, no_formulir) FROM stdin;
\.


--
-- TOC entry 3084 (class 0 OID 53764)
-- Dependencies: 220
-- Data for Name: tabel_struktur_jabatan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_struktur_jabatan (id_struktur, created_at, updated_at, idjabatan, idlevel, idjabatan_atasan, iddepartemen, idjamkerja) FROM stdin;
\.


--
-- TOC entry 3102 (class 0 OID 54012)
-- Dependencies: 238
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at, level, status_user, id_karyawan_personal) FROM stdin;
29	Nizar Alfarizy	nizar.alfarizy@ocbd.co.id	\N	$2y$10$L0d7kVI62T0tm4d4V3ZUXOR0XYqaparbpPZrax2UM25gTcu/Jk4Li	\N	2021-04-16 06:56:52	2021-04-16 06:56:52	karyawan	1	25
7	Yannes Pasaribu	yannes.pasaribu@ocbd.co.id	\N	$2y$10$SYjBdW3.oCAEVtAuYZqoLeT68H29rJmVfEA4uDZGOtuboeg.OZ8JS	\N	2021-04-15 08:02:53	2021-04-15 08:02:53	karyawan	1	11
8	Eka Surya Wijaya	eka.surya@ocbd.co.id	\N	$2y$10$6u3DrNgP9jGn2MpNvp/qnepFczMU./eIBY7dlJbEcYNjaqSDw3AOi	\N	2021-04-15 08:03:00	2021-04-15 08:03:00	karyawan	1	12
9	Imelda Fransisca	imel@olympic-development.com	\N	$2y$10$rHCACUZ1Mh7OyuzjOZRwleqHw39FvOYHSZRqW3z8HzTHmfwyL2C92	\N	2021-04-15 08:03:04	2021-04-15 08:03:04	karyawan	1	13
10	Shelly Maryanti	shelly.maryanti@ocbd.co.id	\N	$2y$10$NcrzsWmkPw4UYWhvdAFiTeW7K4c6lN.0IuBml4vdGXO0VATZyGAZG	\N	2021-04-15 08:03:08	2021-04-15 08:03:08	karyawan	1	14
11	Wahyuningsih	wahyuningsih@ocbd.co.id	\N	$2y$10$fU9s5AJ.Uy15qt8oa/3yyubKXSA8iADZLlucaw1jvsBfx3mTb00oe	\N	2021-04-15 08:03:11	2021-04-15 08:03:11	karyawan	1	15
12	Angga Eka Putra	angga.eka@olympic-development.com	\N	$2y$10$kRzzD6cTZEEdFnP8T2lpIumodFlcbL35DryVwthn6moM3CXpW.CTS	\N	2021-04-15 08:03:15	2021-04-15 08:03:15	karyawan	1	17
13	Sandro Marcelino Damanik	sandro.marcelino@ocbd.co.id	\N	$2y$10$pu6HU9WDoJUAtABZ.any5O/PYcDV7hFz8WnpHX339c1MQzDf409NG	\N	2021-04-15 08:03:22	2021-04-15 08:03:22	karyawan	1	18
15	Dwi Wulandari	dwi.wulandari@ocbd.co.id	\N	$2y$10$JwYhYHq600jCoiBKxfMyMucxeuGZaRDxgXcJyVh8gEZjlpRKWPtwe	\N	2021-04-15 08:06:49	2021-04-15 08:06:49	karyawan	1	71
16	Dina Arsitarely	dina.arsitarely@ocbd.co.id	\N	$2y$10$jtlu4lvo7b88BGlo2VSuSeX1iVHh98oXn1gvqmjs568o.gOwJ.ouK	\N	2021-04-15 08:07:02	2021-04-15 08:07:02	karyawan	1	39
17	Ir. Eko Wiyantono	eko.wiyantono@ocbd.co.id	\N	$2y$10$sxrpASJogH1pY3nqRo/mPOmEKAHayONiPlhrEFr4TWau3y5pjE6H.	\N	2021-04-15 08:07:09	2021-04-15 08:07:09	karyawan	1	40
18	Suci Fitriyanto	suci.fitriyanto@ocbd.co.id	\N	$2y$10$9mPUuSdkbYev9h/tO90L3eulR0g2FIm7v26CGZROwwR/qsEySs61a	\N	2021-04-15 08:07:16	2021-04-15 08:07:16	karyawan	1	61
30	Putri Permatasari	putri.permatasari@ocbd.co.id	\N	$2y$10$fWNWL7aRpLJiPkUm4p.NKeKxYlvMKIt5J1n4nF5x.weAqfxMy4Z4i	\N	2021-04-16 06:57:28	2021-04-16 06:57:28	karyawan	1	57
31	M. Alit Sanusi	alit@ocbd.co.id	\N	$2y$10$ypBVmWHvJx.MA7Oa9cl9p.EIyzpCA8p4QuTDwlSehf4v34CjZ7g1K	\N	2021-04-16 07:00:30	2021-04-16 07:00:30	karyawan	1	51
32	Sofyan Akbar Supni Komara	sofyan.akbar@ocbd.co.id	\N	$2y$10$0QFw1P1lx/KQy1RGQ8B3BOtdo9h5/0dNGO2M88bYNuQXQ8.07wMI6	\N	2021-04-16 07:01:18	2021-04-16 07:01:18	karyawan	1	76
33	Ivan Andrian	ivan.andrian@ocbd.co.id	\N	$2y$10$GlFZMkjUU1nFz65bNGkMnuJhZK8Wl/ECEJf1yjAKDie20QgTzQv3C	\N	2021-04-16 07:02:07	2021-04-16 07:02:07	karyawan	1	49
34	Ahmad Fauzi Mulyadi	ahmad.fauzi@ocbd.co.id	\N	$2y$10$u1R7L/gChxJ9lWpde1NPQe0ynNFrG62VGoKwloZP1rDFHG2Ap110O	\N	2021-04-16 07:02:28	2021-04-16 07:02:28	karyawan	1	60
5	Prasetiawan G.S	prasetiawan@ocbd.co.id	\N	$2y$10$.AqZQAh6SU58AyCXSfGMjOJlQBaqxNft90HwTjvEzWgVOTD/ken6y	z1ODV5qhQuJchUljlAPcZnpEbWynmWtbv9ELzwpLliKEKCi7ZHCdlegiSgWH	2021-03-10 08:23:07	2021-03-10 08:23:07	karyawan	1	16
3	Virthon Hutagalung	virthon.hutagalung@ocbd.co.id	\N	$2y$10$YAluXYv4vLi/C8PlNJgL4OK2JCg/kSDV48YmgwaFJW9Khi5hB4Qkq	DfWe9jioBMmgxEPnhsWD0mabFb5uUFA0RlFlsyvZM1M8WrN5WbC2srjvcZGy	2021-03-10 07:25:57	2021-03-10 07:25:57	karyawan	1	10
19	Luqman Al Hakim	luqman.al@ocbd.co.id	\N	$2y$10$BPzaN3gP/v83HHy6vi9/WeGR79FiT1FYIHogcgjOhnMUpjY3mxM3u	\N	2021-04-15 09:01:27	2021-04-15 09:01:27	karyawan	1	32
35	Wawan Sugianto	wawan.sugianto@ocbd.co.id	\N	$2y$10$Qri7P2rNoTTtPpQaPe149upmYziPYG7rE27Wm9Z.7ZiJi432cHs4O	\N	2021-04-16 07:02:56	2021-04-16 07:02:56	karyawan	1	63
20	Jeffry Alvianto	jeffry.alvianto@ocbd.co.id	\N	$2y$10$tXuVegELwJO1/aqWZQaHbeCJvI6MLWL/iMNKaQdJD/A.ExwI5LG82	\N	2021-04-16 06:51:06	2021-04-16 06:51:06	karyawan	1	52
21	Hendrik Indra	hendrik.indra@ocbd.co.id	\N	$2y$10$x9fiPb4hduS1J9aZqQCfteaNUUcMofOxglwsdi55h8/c2/LVH2mfm	\N	2021-04-16 06:51:32	2021-04-16 06:51:32	karyawan	1	74
22	Panggih Kurnianto, S.T.	panggih.kurnianto,@ocbd.co.id	\N	$2y$10$gwVU5q2VFRaxZtOiDjhHhePZXuUsbPEi2WAMSqbBVtPWDNj7hu2fO	\N	2021-04-16 06:52:02	2021-04-16 06:52:02	karyawan	1	24
36	Muchlis	muchlis@ocbd.co.id	\N	$2y$10$RqTU4tdbCL6SPoAUjtaRnOsCsx/tubbHt3KkdmrKE1yR4.B2QJKoO	\N	2021-04-16 07:04:23	2021-04-16 07:04:23	karyawan	1	37
37	Mega Nur Fitria	mega.nur@ocbd.co.id	\N	$2y$10$XTsY8q2o728cLKntgQXZrOfYs68XmaDT7wzQIQ.eK6s9hXnSXOC.K	\N	2021-04-16 07:07:46	2021-04-16 07:07:46	karyawan	1	47
23	Aoedronick Todo P. Siagian ST	aoedronick.todo@ocbd.co.id	\N	$2y$10$CN6aaTlDmiNdoRa3DBS4a.cmqJcange9mkCXaF5AXEP26Bhvf1hz6	\N	2021-04-16 06:52:15	2021-04-16 06:52:15	karyawan	1	34
24	Adhithia Sigit Purwono	adhithia.sigit@ocbd.co.id	\N	$2y$10$qn6UuNu.ybSyuNlwEbwBaObVZ17U7ZgrTsDb06ro.4UaO0Sp00sga	\N	2021-04-16 06:52:40	2021-04-16 06:52:40	karyawan	1	70
25	Yusuf Ibrahim	yusuf.ibrahim@ocbd.co.id	\N	$2y$10$gxBvlYu/AJYhyIeiguWgfulLEvuU6BbWVYUU0c0iVfQLZ5GcXhxUq	\N	2021-04-16 06:53:06	2021-04-16 06:53:06	karyawan	1	30
27	Mukhamad Imammudin	mukhamad.imammudin@ocbd.co.id	\N	$2y$10$w0lCcnxuFiOjOTlvDAg.mO7wLg6RJQUeRkSy/zRPJK141kAkE0uvG	\N	2021-04-16 06:55:55	2021-04-16 06:55:55	karyawan	1	26
28	Derin Romalia	derin.romalia@ocbd.co.id	\N	$2y$10$r3xBJIQcAdx0.KufcI8mVeysRiQUGQ1u6twqR07F2EoC/Zk/xssDe	\N	2021-04-16 06:56:19	2021-04-16 06:56:19	karyawan	1	29
38	Burhannudin	burhannudin@ocbd.co.id	\N	$2y$10$NrZW9k0dl9xAVjDJbcF5j.VeR9wDJsMBPrCpU0ayQ5JrZ1.6KTU7S	\N	2021-04-16 07:11:30	2021-04-16 07:11:30	karyawan	1	38
39	Ahmad Nawawi	ahmad.nawawi@ocbd.co.id	\N	$2y$10$VZUBu/vHJQ0q5y7Y.CDjxOZO2f..jtiocUAMJCAgtfZjKsCCfuBzy	\N	2021-04-16 07:14:20	2021-04-16 07:14:20	karyawan	1	62
40	Alfarisi	alfarisi@ocbd.co.id	\N	$2y$10$owHV7Re5lUVxy2T1W2pS4OFt/Y3RNhlybZKtFTw10vc1WJXQJ1W26	\N	2021-04-16 07:15:02	2021-04-16 07:15:02	karyawan	1	81
41	Muhamad Ramdani	muhamad.ramdani@ocbd.co.id	\N	$2y$10$8ecqBHgsvO7cdBmEhOQ4zeNdjJcGH6T0NImmVMQlk2cscSG1dMiJi	\N	2021-04-16 07:15:38	2021-04-16 07:15:38	karyawan	1	83
42	Dedi Anggoro	dedi.anggoro@ocbd.co.id	\N	$2y$10$8DW9GU9feCjE4I5PYSdc.ud9Rkffi6fHw2bv4dbRXpvcHhsKBqD6q	\N	2021-04-16 07:16:04	2021-04-16 07:16:04	karyawan	1	90
43	Rahmat Kusnanto	rahmat.kusnanto@ocbd.co.id	\N	$2y$10$EAWOWO.Rk3oXzNvWHjO/oe3pW0g1z382P1HHOrl6xcxq3sE8QM72K	\N	2021-04-16 07:16:43	2021-04-16 07:16:43	karyawan	1	41
44	Sumarta	sumarta@ocbd.co.id	\N	$2y$10$pG64Q/bvTTkppSMcrhFXbuvWmGn0g3hVwbGEuNZo0VRhOoFNY0gZK	\N	2021-04-16 07:21:10	2021-04-16 07:21:10	karyawan	1	43
45	Lukman Nulhakim	lukman.nulhakim@ocbd.co.id	\N	$2y$10$54RifGbMp2UFZxzZWwlb3OkeVmoU2t3O5XcNpKS7lZc3.27bFR5Aa	\N	2021-04-16 07:21:42	2021-04-16 07:21:42	karyawan	1	46
46	Farhan Jamil	farhan.jamil@ocbd.co.id	\N	$2y$10$POSX782SBjWsRfxSQXviaef1bQ6xE0yMHLJurrV5xdzmp5.dqwema	\N	2021-04-16 07:22:25	2021-04-16 07:22:25	karyawan	1	58
26	Wildan Awaludin	wildan.awaludin@ocbd.co.id	\N	$2y$10$IptmfS/G9qIcSSo0efCCKOvG2z7BIEHW48haje5JMFFYKxdAvmLr6	nGE1yhjc6r3guS84qjj5q49k21wplrGvB4Am9gY8Q68bZufZmwVsWR1ouaOG	2021-04-16 06:53:32	2021-04-16 06:53:32	karyawan	1	36
6	Niko Arsi Harkenijandra	niko.arsi@ocbd.co.id	\N	$2y$10$BfTJvNPO/ZnbDIqK3yhb9enR7.NXDiijJ/wQ5/5v9M38p7R7jdON6	H7ckXfErFrAGVOZP0rmm1hoUm4I275e24hOvj0GnGVgsXQDcM5BpYUF3Xcd3	2021-04-15 08:00:12	2021-04-15 08:00:12	karyawan	1	31
47	Ridwan	ridwan@ocbd.co.id	\N	$2y$10$9owXD5/7EDKVUHYqA3i3QudTBg5lI.ZTCVoP0thb5lHQufVLUwUMW	\N	2021-04-16 07:23:18	2021-04-16 07:23:18	karyawan	1	59
48	Muhamad Ibnu Maulana	muhamad.ibnu@ocbd.co.id	\N	$2y$10$N2bFneN5bzAAp1fqVeHFDug3ZteH/fDDD5MPBus/RVw84t.lg1iT.	\N	2021-04-16 07:23:54	2021-04-16 07:23:54	karyawan	1	84
49	Andika Maulana Akbar	andika.maulana@ocbd.co.id	\N	$2y$10$MwvikIjGDZW8v1VcgFXJfuh2KFuyOmi5zC7hgCIofiC3NPvUC75re	\N	2021-04-16 07:24:35	2021-04-16 07:24:35	karyawan	1	95
50	Ir Zakaria Antomi	zakaria@ocbd.co.id	\N	$2y$10$aFawU3tdnEHbxfqPOp5ode5loAq5kptHVi4em7aLjUP3m7yHtF9eO	\N	2021-04-16 07:25:40	2021-04-16 07:25:40	karyawan	1	80
51	Nurwanto	nurwanto@ocbd.co.id	\N	$2y$10$S6DFRTCiNljNuxKXybHFsOKIkx61yhWVEqsdLgNf3we7I8vU8RBp.	\N	2021-04-16 07:28:34	2021-04-16 07:28:34	karyawan	1	66
52	Ryan Andresta Wiguna	ryan.andresta@ocbd.co.id	\N	$2y$10$1caFp0DJX0p6SRRryq5YH.81NcHQuenzHCE1zJda5jiO1hbj0VU.W	\N	2021-04-16 07:29:08	2021-04-16 07:29:08	karyawan	1	44
53	Sunardi	sunardi@ocbd.co.id	\N	$2y$10$alnphEpxQELmt8Rkqix9ZeQ./wVaclNb0SpkP3bH/3s8QXuFnq7Km	\N	2021-04-16 07:29:45	2021-04-16 07:29:45	karyawan	1	56
54	Ardian Hary Sudarto	ardian.hary@ocbd.co.id	\N	$2y$10$1BnBjNYkDHX5zw8LEincSOIkY45uORNI4CCPvnymUMLUsO9FHyS3a	\N	2021-04-16 07:30:10	2021-04-16 07:30:10	karyawan	1	33
55	Femmy Tantiana	femmy.tantiana@ocbd.co.id	\N	$2y$10$./0x.hmYqhC/rahgGgedUOvKLQ/AhXc/IzH42ofJnNn6qDVnP/07G	\N	2021-04-16 07:33:46	2021-04-16 07:33:46	karyawan	1	27
56	Meilyana	meilyana@ocbd.co.id	\N	$2y$10$c6D2jFGOiVFa6FlEpESqqeman6tANDp8V2ckJQaMMIrt2AzCmA4zq	\N	2021-04-16 07:34:26	2021-04-16 07:34:26	karyawan	1	73
57	Enjang Misbah	enjang.misbah@ocbd.co.id	\N	$2y$10$XfigMIz0apyx6M6VHUCwnOycXm4TGoFwPaD6VijogjDAyg3Rudng.	\N	2021-04-16 07:35:01	2021-04-16 07:35:01	karyawan	1	64
58	Rendy Dwi Putra	rendy.dwi@ocbd.co.id	\N	$2y$10$6Bn91dVOArvzYw6EoK5iVORJiocRPX.DywFHfpcefie.1YDlAj5OS	\N	2021-04-16 07:36:23	2021-04-16 07:36:23	karyawan	1	50
59	Asep Saepulloh	asep.saepulloh@ocbd.co.id	\N	$2y$10$vghd/zye517SB2DiQQWTq.mcmjZqVk/FkWYRrZb57t66gbjk.gD.C	\N	2021-04-16 07:37:19	2021-04-16 07:37:19	karyawan	1	75
60	Arip Rahman Hidayat	arip.rahman@ocbd.co.id	\N	$2y$10$wkNfpMKst4Fqf8f4V3RsnO.YDdLvqhwvLurmyT/6dIAGvTxWMq9kG	\N	2021-04-16 07:37:52	2021-04-16 07:37:52	karyawan	1	65
61	Budi Dwinanto	budi.dwinanto@ocbd.co.id	\N	$2y$10$HkdXRWFPzdTQexl9OvCYy.fxCx7IpmJAZ0T2/rn.rnnaj7s/PVO8C	\N	2021-04-16 07:38:17	2021-04-16 07:38:17	karyawan	1	78
62	Theodore David P.S	theodore.david@ocbd.co.id	\N	$2y$10$coZqRD6lrlpih8haZ6vnueq0aqeK/9GFWzCchUeM244gUtVeTib3W	\N	2021-04-16 07:39:00	2021-04-16 07:39:00	karyawan	1	72
63	Marini	marini@ocbd.co.id	\N	$2y$10$znOFAIi3dmD7PHDHHZJ/eun6kdn5C3c3q3rs759rNh3wMEGQ88a8W	\N	2021-04-16 07:39:47	2021-04-16 07:39:47	karyawan	1	55
64	Muhamad Noor	muhamad.noor@ocbd.co.id	\N	$2y$10$/SUEHnucU6xD5I1BNQtNg.pTBBc.2YuJxCmAtmrTsfvnQ7P573wBm	\N	2021-04-16 07:41:06	2021-04-16 07:41:06	karyawan	1	69
65	Sartika Puji Astuti	sartika.puji@ocbd.co.id	\N	$2y$10$fNkQpQwR3QIyWoYLD7H0OOUuxUpdKeZ7Rj75TK24kSiDDRq7EuhmG	\N	2021-04-16 07:41:41	2021-04-16 07:41:41	karyawan	1	28
66	Bepin Zahari	bepin.zahari@ocbd.co.id	\N	$2y$10$bOt5UjFqkBFz1E3kejPE1.ciY7DF5BclYFbhI6oixyHHBRk9DD9Jm	\N	2021-04-16 07:42:20	2021-04-16 07:42:20	karyawan	1	54
67	Agus Setiawan	agus.setiawan@ocbd.co.id	\N	$2y$10$7uf7Bew6uaAFoU.4qZnehO8ldIhHIJLvVVv2eOgkJgnITzG/4xSDy	\N	2021-04-16 07:42:57	2021-04-16 07:42:57	karyawan	1	21
68	Nina Marlina	nina.marlina@ocbd.co.id	\N	$2y$10$N4WtS/WEwOl0aoQXUT9YOO6etX/4gJCcSLkFxktdlDOe5mgzvvuVa	\N	2021-04-16 07:43:46	2021-04-16 07:43:46	karyawan	1	20
69	M. Rizki Maulana	rizki@ocbd.co.id	\N	$2y$10$HWxxWib.PJa3OSZzbF8tgeIVYv7AqrtPsreG4hhdE0cDrF9ff9ZxS	\N	2021-04-16 07:44:44	2021-04-16 07:44:44	karyawan	1	53
4	Suhartin Ekafacksi	suhartin.ekafacksi@ocbd.co.id	\N	$2y$10$AgRWlG370zj94.j1vvWKAuL8YAujvhAdbvju8K0SgnVMyQbyqcohO	SOKdJCzP0YGOwHAReHv3aOWOqlaI9pb0iy7jvQigF5wBGhkMc4fpnuLkDJwl	2021-03-10 08:17:46	2021-03-10 08:17:46	karyawan	1	22
1	admin HRD	hrd@gmail.com	\N	$2y$10$blVcrIh2xhdfPr1uEkzNpObKXPEL1IrxtdHg0E8x403xDuMuyN.pu	oRbY1WlHRFRHNlxLlDjN10TowLEaLGgOljCG2D0HPTa50tJL2O9erI5ZjM9a	2020-10-08 08:38:19	2020-10-08 08:38:19	admin	1	\N
2	Novan Abdilah Agilyansyah	novan.abdilah@ocbd.co.id	\N	$2y$10$Rc11bYG9b1QvP.5FxOf30OootmL1icwYCFF2tCfxoBO0RT0yNmtQW	IvmAA0yafziWDwsgD0cyJuCltflk7CyHM8BfuS030KCvqW9GqlpibVfsiK5j	2021-03-10 03:02:10	2021-03-10 03:02:10	karyawan	1	94
\.


--
-- TOC entry 3150 (class 0 OID 0)
-- Dependencies: 202
-- Name: karyawan_file_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.karyawan_file_id_seq', 17, true);


--
-- TOC entry 3151 (class 0 OID 0)
-- Dependencies: 204
-- Name: karyawan_keluarga_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.karyawan_keluarga_id_seq', 6, true);


--
-- TOC entry 3152 (class 0 OID 0)
-- Dependencies: 206
-- Name: karyawan_pekerjaan_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.karyawan_pekerjaan_id_seq', 3, true);


--
-- TOC entry 3153 (class 0 OID 0)
-- Dependencies: 208
-- Name: karyawan_pendidikan_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.karyawan_pendidikan_id_seq', 6, true);


--
-- TOC entry 3154 (class 0 OID 0)
-- Dependencies: 210
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 2, true);


--
-- TOC entry 3155 (class 0 OID 0)
-- Dependencies: 217
-- Name: tabel_absen_harian_id_kalender_kerja_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_absen_harian_id_kalender_kerja_seq', 3684, true);


--
-- TOC entry 3156 (class 0 OID 0)
-- Dependencies: 239
-- Name: tabel_agama_id_agama_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_agama_id_agama_seq', 12, true);


--
-- TOC entry 3157 (class 0 OID 0)
-- Dependencies: 221
-- Name: tabel_cuti_id_struktur_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_cuti_id_struktur_seq', 23, true);


--
-- TOC entry 3158 (class 0 OID 0)
-- Dependencies: 229
-- Name: tabel_datang_terlambat_id_detail_lembur_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_datang_terlambat_id_detail_lembur_seq', 3, true);


--
-- TOC entry 3159 (class 0 OID 0)
-- Dependencies: 241
-- Name: tabel_departemen_id_departemen_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_departemen_id_departemen_seq', 9, true);


--
-- TOC entry 3160 (class 0 OID 0)
-- Dependencies: 231
-- Name: tabel_ganti_hari_kerja_id_terlambat_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_ganti_hari_kerja_id_terlambat_seq', 4, true);


--
-- TOC entry 3161 (class 0 OID 0)
-- Dependencies: 243
-- Name: tabel_golongan_id_golongan_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_golongan_id_golongan_seq', 17, true);


--
-- TOC entry 3162 (class 0 OID 0)
-- Dependencies: 245
-- Name: tabel_jabatan_id_jabatan_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_jabatan_id_jabatan_seq', 65, true);


--
-- TOC entry 3163 (class 0 OID 0)
-- Dependencies: 253
-- Name: tabel_jam_kerja_id_jamkerja_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_jam_kerja_id_jamkerja_seq', 6, true);


--
-- TOC entry 3164 (class 0 OID 0)
-- Dependencies: 233
-- Name: tabel_jatah_cuti_id_cuti_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_jatah_cuti_id_cuti_seq', 88, true);


--
-- TOC entry 3165 (class 0 OID 0)
-- Dependencies: 215
-- Name: tabel_kalender_kerja_id_agama_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_kalender_kerja_id_agama_seq', 3, true);


--
-- TOC entry 3166 (class 0 OID 0)
-- Dependencies: 249
-- Name: tabel_karyawan_data_id_karyawan_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_karyawan_data_id_karyawan_seq', 116, true);


--
-- TOC entry 3167 (class 0 OID 0)
-- Dependencies: 251
-- Name: tabel_karyawan_personal_id_karyawan_personal_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_karyawan_personal_id_karyawan_personal_seq', 115, true);


--
-- TOC entry 3168 (class 0 OID 0)
-- Dependencies: 213
-- Name: tabel_kategori_absen_id_agama_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_kategori_absen_id_agama_seq', 11, true);


--
-- TOC entry 3169 (class 0 OID 0)
-- Dependencies: 227
-- Name: tabel_lembur_id_jabatan_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_lembur_id_jabatan_seq', 10, true);


--
-- TOC entry 3170 (class 0 OID 0)
-- Dependencies: 247
-- Name: tabel_level_id_level_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_level_id_level_seq', 11, true);


--
-- TOC entry 3171 (class 0 OID 0)
-- Dependencies: 236
-- Name: tabel_log_absen_row_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_log_absen_row_id_seq', 6870, true);


--
-- TOC entry 3172 (class 0 OID 0)
-- Dependencies: 225
-- Name: tabel_penugasan_karyawan_id_level_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_penugasan_karyawan_id_level_seq', 1, false);


--
-- TOC entry 3173 (class 0 OID 0)
-- Dependencies: 223
-- Name: tabel_perjalanan_dinas_id_cuti_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_perjalanan_dinas_id_cuti_seq', 1, false);


--
-- TOC entry 3174 (class 0 OID 0)
-- Dependencies: 219
-- Name: tabel_struktur_jabatan_id_jabatan_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_struktur_jabatan_id_jabatan_seq', 55, true);


--
-- TOC entry 3175 (class 0 OID 0)
-- Dependencies: 237
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 70, true);


--
-- TOC entry 2886 (class 2606 OID 53273)
-- Name: tabel_karyawan_file karyawan_file_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_karyawan_file
    ADD CONSTRAINT karyawan_file_pkey PRIMARY KEY (id_karyawanfile);


--
-- TOC entry 2888 (class 2606 OID 53284)
-- Name: tabel_karyawan_keluarga karyawan_keluarga_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_karyawan_keluarga
    ADD CONSTRAINT karyawan_keluarga_pkey PRIMARY KEY (id_karyawankeluarga);


--
-- TOC entry 2890 (class 2606 OID 53295)
-- Name: tabel_karyawan_pekerjaan karyawan_pekerjaan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_karyawan_pekerjaan
    ADD CONSTRAINT karyawan_pekerjaan_pkey PRIMARY KEY (id_karyawanpekerjaan);


--
-- TOC entry 2892 (class 2606 OID 53306)
-- Name: tabel_karyawan_pendidikan karyawan_pendidikan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_karyawan_pendidikan
    ADD CONSTRAINT karyawan_pendidikan_pkey PRIMARY KEY (id_karyawanpendidikan);


--
-- TOC entry 2894 (class 2606 OID 53596)
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- TOC entry 2901 (class 2606 OID 53745)
-- Name: tabel_absen_harian tabel_absen_harian_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_absen_harian
    ADD CONSTRAINT tabel_absen_harian_pkey PRIMARY KEY (id_absen);


--
-- TOC entry 2925 (class 2606 OID 54059)
-- Name: tabel_agama tabel_agama_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_agama
    ADD CONSTRAINT tabel_agama_pkey PRIMARY KEY (id_agama);


--
-- TOC entry 2905 (class 2606 OID 53777)
-- Name: tabel_cuti tabel_cuti_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_cuti
    ADD CONSTRAINT tabel_cuti_pkey PRIMARY KEY (id_cuti);


--
-- TOC entry 2913 (class 2606 OID 53857)
-- Name: tabel_datang_terlambat tabel_datang_terlambat_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_datang_terlambat
    ADD CONSTRAINT tabel_datang_terlambat_pkey PRIMARY KEY (id_terlambat);


--
-- TOC entry 2927 (class 2606 OID 54067)
-- Name: tabel_departemen tabel_departemen_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_departemen
    ADD CONSTRAINT tabel_departemen_pkey PRIMARY KEY (id_departemen);


--
-- TOC entry 2915 (class 2606 OID 53868)
-- Name: tabel_ganti_hari_kerja tabel_ganti_hari_kerja_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_ganti_hari_kerja
    ADD CONSTRAINT tabel_ganti_hari_kerja_pkey PRIMARY KEY (id_ganti_hari);


--
-- TOC entry 2929 (class 2606 OID 54075)
-- Name: tabel_golongan tabel_golongan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_golongan
    ADD CONSTRAINT tabel_golongan_pkey PRIMARY KEY (id_golongan);


--
-- TOC entry 2931 (class 2606 OID 54083)
-- Name: tabel_jabatan tabel_jabatan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_jabatan
    ADD CONSTRAINT tabel_jabatan_pkey PRIMARY KEY (id_jabatan);


--
-- TOC entry 2939 (class 2606 OID 54126)
-- Name: tabel_jam_kerja tabel_jam_kerja_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_jam_kerja
    ADD CONSTRAINT tabel_jam_kerja_pkey PRIMARY KEY (id_jamkerja);


--
-- TOC entry 2917 (class 2606 OID 53886)
-- Name: tabel_jatah_cuti tabel_jatah_cuti_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_jatah_cuti
    ADD CONSTRAINT tabel_jatah_cuti_pkey PRIMARY KEY (id_jatah_cuti);


--
-- TOC entry 2899 (class 2606 OID 53737)
-- Name: tabel_kalender_kerja tabel_kalender_kerja_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_kalender_kerja
    ADD CONSTRAINT tabel_kalender_kerja_pkey PRIMARY KEY (id_kalender_kerja);


--
-- TOC entry 2935 (class 2606 OID 54103)
-- Name: tabel_karyawan_data tabel_karyawan_data_karyawan_data_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_karyawan_data
    ADD CONSTRAINT tabel_karyawan_data_karyawan_data_pkey PRIMARY KEY (id_karyawan);


--
-- TOC entry 2937 (class 2606 OID 54115)
-- Name: tabel_karyawan_personal tabel_karyawan_personal_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_karyawan_personal
    ADD CONSTRAINT tabel_karyawan_personal_pkey PRIMARY KEY (id_karyawan_personal);


--
-- TOC entry 2897 (class 2606 OID 53729)
-- Name: tabel_kategori_absen tabel_kategori_absen_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_kategori_absen
    ADD CONSTRAINT tabel_kategori_absen_pkey PRIMARY KEY (id_kategori_absen);


--
-- TOC entry 2911 (class 2606 OID 53824)
-- Name: tabel_lembur tabel_lembur_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_lembur
    ADD CONSTRAINT tabel_lembur_pkey PRIMARY KEY (id_lembur);


--
-- TOC entry 2933 (class 2606 OID 54091)
-- Name: tabel_level tabel_level_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_level
    ADD CONSTRAINT tabel_level_pkey PRIMARY KEY (id_level);


--
-- TOC entry 2919 (class 2606 OID 53977)
-- Name: tabel_log_absen tabel_log_absen_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_log_absen
    ADD CONSTRAINT tabel_log_absen_pkey PRIMARY KEY (row_id);


--
-- TOC entry 2909 (class 2606 OID 53813)
-- Name: tabel_perjalanan_detail tabel_penugasan_karyawan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_perjalanan_detail
    ADD CONSTRAINT tabel_penugasan_karyawan_pkey PRIMARY KEY (id_penugasan_karyawan);


--
-- TOC entry 2907 (class 2606 OID 53791)
-- Name: tabel_perjalanan_dinas tabel_perjalanan_dinas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_perjalanan_dinas
    ADD CONSTRAINT tabel_perjalanan_dinas_pkey PRIMARY KEY (id_penugasan);


--
-- TOC entry 2903 (class 2606 OID 53769)
-- Name: tabel_struktur_jabatan tabel_struktur_jabatan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_struktur_jabatan
    ADD CONSTRAINT tabel_struktur_jabatan_pkey PRIMARY KEY (id_struktur);


--
-- TOC entry 2921 (class 2606 OID 54022)
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- TOC entry 2923 (class 2606 OID 54020)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 2895 (class 1259 OID 53616)
-- Name: password_resets_email_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX password_resets_email_index ON public.password_resets USING btree (email);


-- Completed on 2021-05-06 11:16:46

--
-- PostgreSQL database dump complete
--

