--
-- PostgreSQL database dump
--

-- Dumped from database version 12.1
-- Dumped by pg_dump version 12.0

-- Started on 2021-04-15 14:21:44

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
-- TOC entry 213 (class 1259 OID 53254)
-- Name: tabel_karyawan_data; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_karyawan_data (
    id_karyawan integer NOT NULL,
    npk character varying(32) NOT NULL,
    level integer,
    departemen integer NOT NULL,
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
    job_deskripsi character varying(255),
    keterangan character varying(255),
    gaji character varying(32),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    id_karyawan_personal integer,
    status character varying(2) DEFAULT 1,
    golongan integer,
    jabatan integer,
    idatasan1 integer,
    idatasan2 integer,
    idjamkerja integer
);
ALTER TABLE ONLY public.tabel_karyawan_data ALTER COLUMN level SET STATISTICS 100;


ALTER TABLE public.tabel_karyawan_data OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 53307)
-- Name: karyawan_data_id_karyawan_personal_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.karyawan_data_id_karyawan_personal_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.karyawan_data_id_karyawan_personal_seq OWNER TO postgres;

--
-- TOC entry 3132 (class 0 OID 0)
-- Dependencies: 222
-- Name: karyawan_data_id_karyawan_personal_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.karyawan_data_id_karyawan_personal_seq OWNED BY public.tabel_karyawan_data.id_karyawan_personal;


--
-- TOC entry 212 (class 1259 OID 53252)
-- Name: karyawan_data_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.karyawan_data_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.karyawan_data_id_seq OWNER TO postgres;

--
-- TOC entry 3133 (class 0 OID 0)
-- Dependencies: 212
-- Name: karyawan_data_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.karyawan_data_id_seq OWNED BY public.tabel_karyawan_data.id_karyawan;


--
-- TOC entry 215 (class 1259 OID 53265)
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
-- TOC entry 214 (class 1259 OID 53263)
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
-- TOC entry 3134 (class 0 OID 0)
-- Dependencies: 214
-- Name: karyawan_file_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.karyawan_file_id_seq OWNED BY public.tabel_karyawan_file.id_karyawanfile;


--
-- TOC entry 217 (class 1259 OID 53276)
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
-- TOC entry 216 (class 1259 OID 53274)
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
-- TOC entry 3135 (class 0 OID 0)
-- Dependencies: 216
-- Name: karyawan_keluarga_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.karyawan_keluarga_id_seq OWNED BY public.tabel_karyawan_keluarga.id_karyawankeluarga;


--
-- TOC entry 219 (class 1259 OID 53287)
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
-- TOC entry 218 (class 1259 OID 53285)
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
-- TOC entry 3136 (class 0 OID 0)
-- Dependencies: 218
-- Name: karyawan_pekerjaan_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.karyawan_pekerjaan_id_seq OWNED BY public.tabel_karyawan_pekerjaan.id_karyawanpekerjaan;


--
-- TOC entry 221 (class 1259 OID 53298)
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
-- TOC entry 220 (class 1259 OID 53296)
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
-- TOC entry 3137 (class 0 OID 0)
-- Dependencies: 220
-- Name: karyawan_pendidikan_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.karyawan_pendidikan_id_seq OWNED BY public.tabel_karyawan_pendidikan.id_karyawanpendidikan;


--
-- TOC entry 224 (class 1259 OID 53591)
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 53589)
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
-- TOC entry 3138 (class 0 OID 0)
-- Dependencies: 223
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- TOC entry 227 (class 1259 OID 53610)
-- Name: password_resets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_resets (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_resets OWNER TO postgres;

--
-- TOC entry 237 (class 1259 OID 53740)
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
    idatasan integer
);


ALTER TABLE public.tabel_absen_harian OWNER TO postgres;

--
-- TOC entry 236 (class 1259 OID 53738)
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
-- TOC entry 3139 (class 0 OID 0)
-- Dependencies: 236
-- Name: tabel_absen_harian_id_kalender_kerja_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_absen_harian_id_kalender_kerja_seq OWNED BY public.tabel_absen_harian.id_absen;


--
-- TOC entry 203 (class 1259 OID 53188)
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
-- TOC entry 202 (class 1259 OID 53186)
-- Name: tabel_agama_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_agama_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_agama_id_seq OWNER TO postgres;

--
-- TOC entry 3140 (class 0 OID 0)
-- Dependencies: 202
-- Name: tabel_agama_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_agama_id_seq OWNED BY public.tabel_agama.id_agama;


--
-- TOC entry 241 (class 1259 OID 53772)
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
    status character varying(16)
);


ALTER TABLE public.tabel_cuti OWNER TO postgres;

--
-- TOC entry 240 (class 1259 OID 53770)
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
-- TOC entry 3141 (class 0 OID 0)
-- Dependencies: 240
-- Name: tabel_cuti_id_struktur_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_cuti_id_struktur_seq OWNED BY public.tabel_cuti.id_cuti;


--
-- TOC entry 249 (class 1259 OID 53849)
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
-- TOC entry 248 (class 1259 OID 53847)
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
-- TOC entry 3142 (class 0 OID 0)
-- Dependencies: 248
-- Name: tabel_datang_terlambat_id_detail_lembur_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_datang_terlambat_id_detail_lembur_seq OWNED BY public.tabel_datang_terlambat.id_terlambat;


--
-- TOC entry 209 (class 1259 OID 53212)
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
-- TOC entry 208 (class 1259 OID 53210)
-- Name: tabel_departemen_id_level_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_departemen_id_level_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_departemen_id_level_seq OWNER TO postgres;

--
-- TOC entry 3143 (class 0 OID 0)
-- Dependencies: 208
-- Name: tabel_departemen_id_level_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_departemen_id_level_seq OWNED BY public.tabel_departemen.id_departemen;


--
-- TOC entry 251 (class 1259 OID 53860)
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
-- TOC entry 250 (class 1259 OID 53858)
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
-- TOC entry 3144 (class 0 OID 0)
-- Dependencies: 250
-- Name: tabel_ganti_hari_kerja_id_terlambat_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_ganti_hari_kerja_id_terlambat_seq OWNED BY public.tabel_ganti_hari_kerja.id_ganti_hari;


--
-- TOC entry 229 (class 1259 OID 53619)
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
-- TOC entry 228 (class 1259 OID 53617)
-- Name: tabel_golongan_id_jabatan_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_golongan_id_jabatan_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_golongan_id_jabatan_seq OWNER TO postgres;

--
-- TOC entry 3145 (class 0 OID 0)
-- Dependencies: 228
-- Name: tabel_golongan_id_jabatan_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_golongan_id_jabatan_seq OWNED BY public.tabel_golongan.id_golongan;


--
-- TOC entry 205 (class 1259 OID 53196)
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
-- TOC entry 204 (class 1259 OID 53194)
-- Name: tabel_jabatan_id_agama_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_jabatan_id_agama_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_jabatan_id_agama_seq OWNER TO postgres;

--
-- TOC entry 3146 (class 0 OID 0)
-- Dependencies: 204
-- Name: tabel_jabatan_id_agama_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_jabatan_id_agama_seq OWNED BY public.tabel_jabatan.id_jabatan;


--
-- TOC entry 231 (class 1259 OID 53716)
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
-- TOC entry 230 (class 1259 OID 53714)
-- Name: tabel_jam_kerja_id_agama_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_jam_kerja_id_agama_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_jam_kerja_id_agama_seq OWNER TO postgres;

--
-- TOC entry 3147 (class 0 OID 0)
-- Dependencies: 230
-- Name: tabel_jam_kerja_id_agama_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_jam_kerja_id_agama_seq OWNED BY public.tabel_jam_kerja.id_jamkerja;


--
-- TOC entry 253 (class 1259 OID 53878)
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
-- TOC entry 252 (class 1259 OID 53876)
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
-- TOC entry 3148 (class 0 OID 0)
-- Dependencies: 252
-- Name: tabel_jatah_cuti_id_cuti_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_jatah_cuti_id_cuti_seq OWNED BY public.tabel_jatah_cuti.id_jatah_cuti;


--
-- TOC entry 235 (class 1259 OID 53732)
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
-- TOC entry 234 (class 1259 OID 53730)
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
-- TOC entry 3149 (class 0 OID 0)
-- Dependencies: 234
-- Name: tabel_kalender_kerja_id_agama_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_kalender_kerja_id_agama_seq OWNED BY public.tabel_kalender_kerja.id_kalender_kerja;


--
-- TOC entry 211 (class 1259 OID 53220)
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
-- TOC entry 210 (class 1259 OID 53218)
-- Name: tabel_karyawan_personal_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_karyawan_personal_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_karyawan_personal_id_seq OWNER TO postgres;

--
-- TOC entry 3150 (class 0 OID 0)
-- Dependencies: 210
-- Name: tabel_karyawan_personal_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_karyawan_personal_id_seq OWNED BY public.tabel_karyawan_personal.id_karyawan_personal;


--
-- TOC entry 233 (class 1259 OID 53724)
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
-- TOC entry 232 (class 1259 OID 53722)
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
-- TOC entry 3151 (class 0 OID 0)
-- Dependencies: 232
-- Name: tabel_kategori_absen_id_agama_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_kategori_absen_id_agama_seq OWNED BY public.tabel_kategori_absen.id_kategori_absen;


--
-- TOC entry 247 (class 1259 OID 53819)
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
-- TOC entry 246 (class 1259 OID 53817)
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
-- TOC entry 3152 (class 0 OID 0)
-- Dependencies: 246
-- Name: tabel_lembur_id_jabatan_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_lembur_id_jabatan_seq OWNED BY public.tabel_lembur.id_lembur;


--
-- TOC entry 207 (class 1259 OID 53204)
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
-- TOC entry 206 (class 1259 OID 53202)
-- Name: tabel_level_id_jabatan_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tabel_level_id_jabatan_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tabel_level_id_jabatan_seq OWNER TO postgres;

--
-- TOC entry 3153 (class 0 OID 0)
-- Dependencies: 206
-- Name: tabel_level_id_jabatan_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_level_id_jabatan_seq OWNED BY public.tabel_level.id_level;


--
-- TOC entry 254 (class 1259 OID 53931)
-- Name: tabel_log_absen; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tabel_log_absen (
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    "PIN" character varying(20),
    id_karyawan_personal integer,
    checktime timestamp(0) without time zone NOT NULL,
    checktype character varying(10),
    alatabsen character varying(16),
    row_id integer NOT NULL
);


ALTER TABLE public.tabel_log_absen OWNER TO postgres;

--
-- TOC entry 255 (class 1259 OID 53970)
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
-- TOC entry 3154 (class 0 OID 0)
-- Dependencies: 255
-- Name: tabel_log_absen_row_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_log_absen_row_id_seq OWNED BY public.tabel_log_absen.row_id;


--
-- TOC entry 245 (class 1259 OID 53808)
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
-- TOC entry 244 (class 1259 OID 53806)
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
-- TOC entry 3155 (class 0 OID 0)
-- Dependencies: 244
-- Name: tabel_penugasan_karyawan_id_level_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_penugasan_karyawan_id_level_seq OWNED BY public.tabel_perjalanan_detail.id_penugasan_karyawan;


--
-- TOC entry 243 (class 1259 OID 53783)
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
-- TOC entry 242 (class 1259 OID 53781)
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
-- TOC entry 3156 (class 0 OID 0)
-- Dependencies: 242
-- Name: tabel_perjalanan_dinas_id_cuti_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_perjalanan_dinas_id_cuti_seq OWNED BY public.tabel_perjalanan_dinas.id_penugasan;


--
-- TOC entry 239 (class 1259 OID 53764)
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
-- TOC entry 238 (class 1259 OID 53762)
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
-- TOC entry 3157 (class 0 OID 0)
-- Dependencies: 238
-- Name: tabel_struktur_jabatan_id_jabatan_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tabel_struktur_jabatan_id_jabatan_seq OWNED BY public.tabel_struktur_jabatan.id_struktur;


--
-- TOC entry 226 (class 1259 OID 53599)
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
    status_user integer,
    id_karyawan_personal integer,
    imei character varying(128),
    macaddr character varying(128)
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 53597)
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
-- TOC entry 3158 (class 0 OID 0)
-- Dependencies: 225
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- TOC entry 2871 (class 2604 OID 53594)
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- TOC entry 2877 (class 2604 OID 53743)
-- Name: tabel_absen_harian id_absen; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_absen_harian ALTER COLUMN id_absen SET DEFAULT nextval('public.tabel_absen_harian_id_kalender_kerja_seq'::regclass);


--
-- TOC entry 2859 (class 2604 OID 53191)
-- Name: tabel_agama id_agama; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_agama ALTER COLUMN id_agama SET DEFAULT nextval('public.tabel_agama_id_seq'::regclass);


--
-- TOC entry 2879 (class 2604 OID 53775)
-- Name: tabel_cuti id_cuti; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_cuti ALTER COLUMN id_cuti SET DEFAULT nextval('public.tabel_cuti_id_struktur_seq'::regclass);


--
-- TOC entry 2883 (class 2604 OID 53852)
-- Name: tabel_datang_terlambat id_terlambat; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_datang_terlambat ALTER COLUMN id_terlambat SET DEFAULT nextval('public.tabel_datang_terlambat_id_detail_lembur_seq'::regclass);


--
-- TOC entry 2862 (class 2604 OID 53215)
-- Name: tabel_departemen id_departemen; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_departemen ALTER COLUMN id_departemen SET DEFAULT nextval('public.tabel_departemen_id_level_seq'::regclass);


--
-- TOC entry 2884 (class 2604 OID 53863)
-- Name: tabel_ganti_hari_kerja id_ganti_hari; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_ganti_hari_kerja ALTER COLUMN id_ganti_hari SET DEFAULT nextval('public.tabel_ganti_hari_kerja_id_terlambat_seq'::regclass);


--
-- TOC entry 2873 (class 2604 OID 53622)
-- Name: tabel_golongan id_golongan; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_golongan ALTER COLUMN id_golongan SET DEFAULT nextval('public.tabel_golongan_id_jabatan_seq'::regclass);


--
-- TOC entry 2860 (class 2604 OID 53199)
-- Name: tabel_jabatan id_jabatan; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_jabatan ALTER COLUMN id_jabatan SET DEFAULT nextval('public.tabel_jabatan_id_agama_seq'::regclass);


--
-- TOC entry 2874 (class 2604 OID 53719)
-- Name: tabel_jam_kerja id_jamkerja; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_jam_kerja ALTER COLUMN id_jamkerja SET DEFAULT nextval('public.tabel_jam_kerja_id_agama_seq'::regclass);


--
-- TOC entry 2885 (class 2604 OID 53881)
-- Name: tabel_jatah_cuti id_jatah_cuti; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_jatah_cuti ALTER COLUMN id_jatah_cuti SET DEFAULT nextval('public.tabel_jatah_cuti_id_cuti_seq'::regclass);


--
-- TOC entry 2876 (class 2604 OID 53735)
-- Name: tabel_kalender_kerja id_kalender_kerja; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_kalender_kerja ALTER COLUMN id_kalender_kerja SET DEFAULT nextval('public.tabel_kalender_kerja_id_agama_seq'::regclass);


--
-- TOC entry 2865 (class 2604 OID 53257)
-- Name: tabel_karyawan_data id_karyawan; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_karyawan_data ALTER COLUMN id_karyawan SET DEFAULT nextval('public.karyawan_data_id_seq'::regclass);


--
-- TOC entry 2867 (class 2604 OID 53268)
-- Name: tabel_karyawan_file id_karyawanfile; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_karyawan_file ALTER COLUMN id_karyawanfile SET DEFAULT nextval('public.karyawan_file_id_seq'::regclass);


--
-- TOC entry 2868 (class 2604 OID 53279)
-- Name: tabel_karyawan_keluarga id_karyawankeluarga; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_karyawan_keluarga ALTER COLUMN id_karyawankeluarga SET DEFAULT nextval('public.karyawan_keluarga_id_seq'::regclass);


--
-- TOC entry 2869 (class 2604 OID 53290)
-- Name: tabel_karyawan_pekerjaan id_karyawanpekerjaan; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_karyawan_pekerjaan ALTER COLUMN id_karyawanpekerjaan SET DEFAULT nextval('public.karyawan_pekerjaan_id_seq'::regclass);


--
-- TOC entry 2870 (class 2604 OID 53301)
-- Name: tabel_karyawan_pendidikan id_karyawanpendidikan; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_karyawan_pendidikan ALTER COLUMN id_karyawanpendidikan SET DEFAULT nextval('public.karyawan_pendidikan_id_seq'::regclass);


--
-- TOC entry 2863 (class 2604 OID 53223)
-- Name: tabel_karyawan_personal id_karyawan_personal; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_karyawan_personal ALTER COLUMN id_karyawan_personal SET DEFAULT nextval('public.tabel_karyawan_personal_id_seq'::regclass);


--
-- TOC entry 2875 (class 2604 OID 53727)
-- Name: tabel_kategori_absen id_kategori_absen; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_kategori_absen ALTER COLUMN id_kategori_absen SET DEFAULT nextval('public.tabel_kategori_absen_id_agama_seq'::regclass);


--
-- TOC entry 2882 (class 2604 OID 53822)
-- Name: tabel_lembur id_lembur; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_lembur ALTER COLUMN id_lembur SET DEFAULT nextval('public.tabel_lembur_id_jabatan_seq'::regclass);


--
-- TOC entry 2861 (class 2604 OID 53207)
-- Name: tabel_level id_level; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_level ALTER COLUMN id_level SET DEFAULT nextval('public.tabel_level_id_jabatan_seq'::regclass);


--
-- TOC entry 2886 (class 2604 OID 53972)
-- Name: tabel_log_absen row_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_log_absen ALTER COLUMN row_id SET DEFAULT nextval('public.tabel_log_absen_row_id_seq'::regclass);


--
-- TOC entry 2881 (class 2604 OID 53811)
-- Name: tabel_perjalanan_detail id_penugasan_karyawan; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_perjalanan_detail ALTER COLUMN id_penugasan_karyawan SET DEFAULT nextval('public.tabel_penugasan_karyawan_id_level_seq'::regclass);


--
-- TOC entry 2880 (class 2604 OID 53786)
-- Name: tabel_perjalanan_dinas id_penugasan; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_perjalanan_dinas ALTER COLUMN id_penugasan SET DEFAULT nextval('public.tabel_perjalanan_dinas_id_cuti_seq'::regclass);


--
-- TOC entry 2878 (class 2604 OID 53767)
-- Name: tabel_struktur_jabatan id_struktur; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_struktur_jabatan ALTER COLUMN id_struktur SET DEFAULT nextval('public.tabel_struktur_jabatan_id_jabatan_seq'::regclass);


--
-- TOC entry 2872 (class 2604 OID 53602)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- TOC entry 3095 (class 0 OID 53591)
-- Dependencies: 224
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	2014_10_12_000000_create_users_table	1
2	2014_10_12_100000_create_password_resets_table	1
\.


--
-- TOC entry 3098 (class 0 OID 53610)
-- Dependencies: 227
-- Data for Name: password_resets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_resets (email, token, created_at) FROM stdin;
novanokkey@gmail.com	$2y$10$mpWWzmWGRAwHzOV/anLwJe316pY3Ga3NIIMmearU.yl.mqWnYWakC	2021-03-04 09:32:58
novan.abdilah@ocbd.co.id	$2y$10$td6Ap.riG843JuKQJA8ytuYdklam4wbEr3rEIYoGuPzoewg/hBnMq	2021-03-04 09:34:25
\.


--
-- TOC entry 3108 (class 0 OID 53740)
-- Dependencies: 237
-- Data for Name: tabel_absen_harian; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_absen_harian (id_absen, created_at, updated_at, keterangan, jam_masuk, terlambat, diubaholeh, diubahtgl, alatabsen, jam_plg, id_karyawan_personal, tgl, totaljam, tahun, bulan, status_absen, foto, status_verifikasi, lat, lng, idatasan) FROM stdin;
80	2021-04-01 09:17:34	2021-04-01 09:19:00	\N	16:16:38	28838	\N	\N	web	16:17:34	94	2021-04-01	56	2021	04	I	60658fae2ee3f.png	0	\N	\N	\N
82	2021-04-05 06:18:01	2021-04-05 06:18:01	\N	13:17:55	18115	\N	\N	web	\N	94	2021-04-05	\N	2021	04	I	1617603481serviceac4.jpg	0	\N	\N	31
\.


--
-- TOC entry 3074 (class 0 OID 53188)
-- Dependencies: 203
-- Data for Name: tabel_agama; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_agama (id_agama, agama, created_at, updated_at) FROM stdin;
3	BUDHA	\N	\N
4	HINDU	2020-10-06 03:52:05	2020-10-06 03:52:05
5	PROTESTAN	2020-10-06 03:52:18	2020-10-06 03:52:18
1	ISLAM	\N	2020-10-06 04:34:29
2	KRISTEN	\N	2020-10-06 04:34:33
\.


--
-- TOC entry 3112 (class 0 OID 53772)
-- Dependencies: 241
-- Data for Name: tabel_cuti; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_cuti (id_cuti, created_at, updated_at, tgl_pengajuan, tgl_cuti_dari, sisa_cuti, statuskriteria_ijin, keterangan, statuskeputusan, status_pengajuan, id_karyawan_personal, tgl_cuti_sampai, jml_cuti, idatasan2, idatasan1, alasan_tolak, status) FROM stdin;
12	2021-04-05 17:02:50	2021-04-05 17:04:11	2021-04-05	2021-04-09	\N	cp	keperluan keluarga	\N	1	94	2021-04-09	1	10	31	oke	cuti
13	2021-04-05 17:07:34	2021-04-05 17:13:05	2021-04-05	2021-04-30	\N	lain	sakit	\N	1	94	2021-05-01	2	10	31	ok	sakit
14	2021-04-05 17:14:30	2021-04-05 17:14:48	2021-04-05	2021-04-20	\N	lain	ijin mau ke disduk	\N	1	94	2021-04-20	1	10	31	oke	ijin
15	2021-04-08 15:15:27	2021-04-08 15:20:13	2021-04-08	2021-04-12	\N	cp	sasa	\N	1	94	2021-04-12	1	10	31	ok	cuti
\.


--
-- TOC entry 3120 (class 0 OID 53849)
-- Dependencies: 249
-- Data for Name: tabel_datang_terlambat; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_datang_terlambat (id_terlambat, created_at, updated_at, hari, tgl_pengajuan, tgl_terlambat, alasan, status_pengajuan, id_karyawan_personal, keterangan_atasan, atasan1, atasan2, jam) FROM stdin;
1	2021-04-08 14:50:40	2021-04-08 14:55:58	Kamis	2021-04-08	2021-04-08	ke disduk	1	94	ok	31	10	10:00:00
2	2021-04-08 14:56:28	2021-04-08 14:57:30	Kamis	2021-04-08	2021-04-16	mau ke dokter dulu pusing	3	94	pake cuti pribadi aja, nanti kena sp loh	31	10	10:00:00
3	2021-04-08 15:04:57	2021-04-08 15:11:59	Kamis	2021-04-08	2021-04-24	mobil mogok air radiator naik panas jadi nunggu dingin dulu	1	94	ok lanjutkan	31	10	10:00:00
\.


--
-- TOC entry 3080 (class 0 OID 53212)
-- Dependencies: 209
-- Data for Name: tabel_departemen; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_departemen (id_departemen, departemen, created_at, updated_at) FROM stdin;
10	Business Development	2020-10-06 06:36:32	2020-10-13 02:17:42
12	Finance & Accounting	2020-10-06 06:36:49	2020-10-13 02:17:52
13	HRD	2020-10-06 06:36:56	2020-10-13 02:18:00
7	Legal, GA & Estate Management	2020-10-13 02:18:19	2020-10-13 02:18:19
8	Project & Engineer	2020-10-13 02:18:25	2020-10-13 02:18:25
9	Sales & Marketing	2020-10-13 02:18:32	2020-10-13 02:18:32
\.


--
-- TOC entry 3122 (class 0 OID 53860)
-- Dependencies: 251
-- Data for Name: tabel_ganti_hari_kerja; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_ganti_hari_kerja (id_ganti_hari, created_at, updated_at, tgl_pengajuan, tgl_pengganti, pekerjaan_dilakukan, status_pengajuan, alasan, target_output, jam_mulai, jam_akhir, id_karyawan_personal, atasan1, atasan2, tgl_lama, hari, keterangan_atasan) FROM stdin;
3	2021-04-13 13:57:40	2021-04-13 14:01:01	2021-04-13	2021-04-03	pasang kabel listrik dan genset	3	ke disduk	selesai	09:00:00	15:00:00	94	31	10	2021-04-01	Kamis	jangan ganti hari
4	2021-04-13 14:01:36	2021-04-13 14:01:56	2021-04-13	2021-04-17	pasang kabel listrik dan genset	1	urgent supaya tidak ganggu hari kerja	selesai	09:00:00	15:00:00	94	31	10	2021-04-16	Kamis	ok
\.


--
-- TOC entry 3100 (class 0 OID 53619)
-- Dependencies: 229
-- Data for Name: tabel_golongan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_golongan (id_golongan, golongan, created_at, updated_at) FROM stdin;
1	IA	2020-10-16 03:34:32	2020-10-16 03:34:32
2	IB	2020-10-16 03:34:37	2020-10-16 03:34:37
3	IC	2020-10-16 03:34:42	2020-10-16 03:34:47
\.


--
-- TOC entry 3076 (class 0 OID 53196)
-- Dependencies: 205
-- Data for Name: tabel_jabatan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_jabatan (id_jabatan, jabatan, created_at, updated_at) FROM stdin;
13	DraftMan	2020-10-13 02:10:00	2020-10-13 02:10:00
40	President Director	2020-10-13 02:14:14	2020-10-13 02:14:14
41	Project Manager	2020-10-13 02:14:19	2020-10-13 02:14:19
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
\.


--
-- TOC entry 3102 (class 0 OID 53716)
-- Dependencies: 231
-- Data for Name: tabel_jam_kerja; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_jam_kerja (id_jamkerja, jam_mulai, created_at, updated_at, jam_akhir, keterangan, jml_hari_kerja) FROM stdin;
1	08:16:00	\N	2021-02-01 04:27:02	17:30:00	OFFICE	5
7	09:00:00	2021-02-01 04:57:22	2021-02-01 04:57:22	20:00:00	SALES	6
\.


--
-- TOC entry 3124 (class 0 OID 53878)
-- Dependencies: 253
-- Data for Name: tabel_jatah_cuti; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_jatah_cuti (id_jatah_cuti, created_at, updated_at, jatah_cuti, sisa_cuti, keterangan, id_karyawan_personal, tahun) FROM stdin;
88	2021-04-05 09:35:12	2021-04-08 15:20:13	5	3	-	94	2021
\.


--
-- TOC entry 3106 (class 0 OID 53732)
-- Dependencies: 235
-- Data for Name: tabel_kalender_kerja; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_kalender_kerja (id_kalender_kerja, created_at, updated_at, tgl, status_hari, tahun, keterangan) FROM stdin;
3	2021-02-09 03:20:23	2021-02-09 03:20:23	2021-02-02	hari_kerja	2021	kerja normal
2	2021-02-09 03:17:43	2021-02-09 03:25:30	2021-02-01	libur_nasional	2021	libur imlek
\.


--
-- TOC entry 3084 (class 0 OID 53254)
-- Dependencies: 213
-- Data for Name: tabel_karyawan_data; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_karyawan_data (id_karyawan, npk, level, departemen, email_perusahaan, no_kpj, no_bpjs, no_spk, tgl_masuk, mulaitgl_kontrak, akhirtgl_kontrak, masakerja_tahun, masakerja_bulan, masakerja_hari, mulaitgl_evaluasi, akhirtgl_evaluasi, kontrak_ke, status_kepegawaian, masa_kontrak, idfinger, job_deskripsi, keterangan, gaji, created_at, updated_at, id_karyawan_personal, status, golongan, jabatan, idatasan1, idatasan2, idjamkerja) FROM stdin;
16	022016001	1	1	yannes@olympic-development.com	17021775782	0002135671637	\N	2016-09-01 00:00:00	\N	\N	4	1	11	\N	\N	0	3	\N	\N	\N	\N	0	2020-10-13 07:09:17	2020-10-13 07:09:30	11	1	\N	8	\N	\N	\N
17	022016004	1	3	ekasurya@olympic-development.com	14038300928	0001648815827	\N	2017-02-03 00:00:00	\N	\N	3	9	9	\N	\N	0	3	\N	\N	\N	\N	0	2020-10-13 07:11:01	2020-10-13 07:11:19	12	1	\N	16	\N	\N	\N
18	022016004	1	9	imel@olympic-development.com	17021775881	0002103313307	\N	2016-11-11 00:00:00	\N	\N	3	11	1	\N	\N	0	3	\N	\N	\N	\N	0	2020-10-13 07:12:34	2020-10-13 07:13:00	13	1	\N	26	\N	\N	\N
21	022017035	11	4	hrd.csis@gmail.com	17028323016	0001833574959	260/OBP-HCM/SPK/VI/2020	2017-03-01 00:00:00	2020-01-01	2021-05-31	3	7	13	\N	\N	2	2	1	2	\N	\N	0	2020-10-13 07:39:08	2020-10-13 07:39:18	16	1	\N	25	\N	\N	\N
20	022016012	11	3	wahyuningsih@olympic-development.com	17021775907	0001616554091	238/OBP-HCM/SPK/II/2020	2016-11-14 00:00:00	2020-02-15	2022-02-14	3	10	28	\N	\N	2	2	2	39	\N	\N	0	2020-10-13 07:35:00	2020-10-13 07:35:12	15	1	\N	47	\N	\N	\N
22	022017036	11	9	angga.eka@olympic-development.com	19032249161	\N	190/OBP-HCM/SPK/X/2019	2017-10-02 00:00:00	2019-10-02	2020-10-01	3	\N	11	02/04/2020	01/07/2020	1	2	1	82	\N	\N	0	2020-10-13 07:41:43	2020-10-13 07:41:52	17	1	\N	44	\N	\N	\N
23	022018055	4	7	\N	18041626864	0002230867596	259/OBP-HCM/SPK/VI/2020	2018-03-01 00:00:00	2020-06-01	2021-05-31	2	7	13	\N	\N	2	2	1	125	\N	\N	0	2020-10-13 07:45:43	2020-10-13 07:48:33	18	1	\N	32	\N	\N	\N
24	022018062	11	8	\N	18103959039	0001738702383	187/OBP-HCM/SPK/XI/2019	2018-08-13 00:00:00	2019-11-13	2020-11-12	2	2	\N	\N	\N	1	2	1	170	\N	\N	0	2020-10-13 07:56:08	2020-10-13 07:57:42	19	1	\N	50	\N	\N	\N
25	022020011	11	9	\N	\N	0001870501285	209/OBP-HCM/SPK/XII/2019	2018-03-12 00:00:00	2019-12-12	2020-12-11	2	7	2	12/06/2020	11/09/2020	1	2	1	133	\N	\N	0	2020-10-13 08:00:53	2020-10-13 08:00:53	20	1	\N	48	\N	\N	\N
26	022018065	11	9	\N	\N	0002356440748	210/OBP-HCM/SPK/XII/2019	2018-03-12 00:00:00	2019-12-12	2020-12-11	2	7	2	\N	\N	1	2	1	135	\N	\N	0	2020-10-13 08:03:51	2020-10-13 08:04:54	21	1	\N	48	\N	\N	\N
27	022018070	11	4	\N	19032249153	0001106036842	251/OBP-HCM/SPK/III/2020	2018-12-27 00:00:00	2020-03-27	2021-03-26	1	9	16	\N	\N	2	2	1	\N	\N	\N	0	2020-10-13 08:07:34	2020-10-13 08:07:51	22	1	\N	27	\N	\N	\N
28	022018071	1	2	nsebastian@olympic-development.com	\N	\N	\N	2018-03-05 00:00:00	\N	\N	2	7	9	\N	\N	0	3	\N	\N	\N	\N	0	2020-10-13 08:37:43	2020-10-13 08:37:54	23	1	\N	40	\N	\N	\N
29	022018072	10	1	panggih.kurnianto@olympic-development.com	18092135617	0001745332762	177/OBP-HCM/SPK/X/2019	2018-07-02 00:00:00	2019-10-01	2020-09-30	2	3	12	\N	\N	2	2	1	150	\N	\N	0	2020-10-13 08:39:38	2020-10-13 08:39:46	24	1	\N	39	\N	\N	\N
30	022018080	10	3	\N	18085811042	0002358894712	181/OBP-HCM/SPK/X/2019	2018-07-16 00:00:00	2019-10-16	2020-10-15	2	2	28	\N	\N	2	2	1	162	\N	\N	0	2020-10-13 08:41:18	2020-10-13 08:41:56	25	1	\N	2	\N	\N	\N
31	022018102	11	3	\N	19032249195	0001319541401	252/OBP-HCM/SPK/III/2020	2018-12-20 00:00:00	2020-03-20	2021-03-19	1	9	23	\N	\N	2	2	1	198	\N	\N	0	2020-10-13 08:43:19	2020-10-13 08:43:27	26	1	\N	52	\N	\N	\N
32	022019012	10	9	\N	11024771112	0001657459293	189/OBP-HCM/SPK/I/2020	2019-01-01 00:00:00	2020-01-01	2020-12-31	1	9	11	\N	\N	2	2	1	47	\N	\N	0	2020-10-13 08:46:12	2020-10-13 08:46:20	27	1	\N	46	\N	\N	\N
33	022020019	11	9	\N	\N	Ada tunggakan	230/OBP-HCM/SPK/I/2020	2019-01-10 00:00:00	2020-01-10	2021-01-09	1	9	3	10/04/2020	09/07/2020	1	2	1	204	\N	\N	0	2020-10-14 02:32:25	2020-10-14 02:32:25	28	1	\N	44	\N	\N	\N
46	022019156	6	7	\N	20008123463	0001126698849	215/OBP-HCM/SPK/I/2020	2020-01-01 00:00:00	2020-01-01	2020-12-31	\N	\N	\N	\N	\N	1	2	1	273	\N	\N	0	2020-10-14 03:44:55	2020-10-14 03:45:04	41	1	\N	30	\N	\N	\N
38	022019123	11	8	\N	19055178867	0002893323633	278/OBP-HCM/SPK/VII/2020	2019-04-15 00:00:00	2020-06-15	2021-06-14	\N	\N	\N	\N	\N	2	2	\N	232	\N	\N	0	2020-10-14 03:17:28	2020-10-14 03:17:36	33	1	\N	13	\N	\N	\N
39	022019124	11	1	\N	19055178842	0001744506134	279/OBP-HCM/SPK/VII/2020	2019-04-15 00:00:00	2020-07-15	2021-07-14	\N	\N	\N	\N	\N	2	2	1	234	\N	\N	0	2020-10-14 03:19:58	2020-10-14 03:20:06	34	1	\N	7	\N	\N	\N
40	022019132	7	1	\N	20024357491	0002171285908	182/OBP-HCM/SPK/XI/2019	2019-05-06 00:00:00	2019-11-06	2020-11-05	\N	\N	\N	\N	\N	1	2	1	242	\N	\N	0	2020-10-14 03:22:24	2020-10-14 03:22:33	35	1	\N	42	\N	\N	\N
41	022019138	11	1	\N	19074056359	0000060246865	281/OBP-HCM/SPK/VIII/202	2019-05-17 00:00:00	2020-08-16	2021-08-15	\N	\N	\N	\N	\N	2	2	1	248	\N	\N	0	2020-10-14 03:31:34	2020-10-14 03:31:42	36	1	\N	23	\N	\N	\N
42	022019145	6	7	\N	20008123448	PBI (JAMKESDA KAB. BOGOR)	214/OBP-HCM/SPK/I/2020	2020-01-01 00:00:00	2020-01-01	2020-12-31	\N	\N	\N	\N	\N	1	2	1	255	\N	\N	0	2020-10-14 03:33:32	2020-10-14 03:33:42	37	1	\N	24	\N	\N	\N
43	022019146	6	7	\N	20008123521	0002248637084	213/OBP-HCM/SPK/I/2020	2020-01-01 00:00:00	2020-01-01	2020-12-31	\N	\N	\N	\N	\N	1	2	1	256	\N	\N	0	2020-10-14 03:35:14	2020-10-14 03:35:24	38	1	\N	24	\N	\N	\N
44	022019151	11	7	\N	19085429595	0001620382599	180/OBP-HCM/SPK/X/2019	2019-07-15 00:00:00	2019-10-15	2020-10-14	\N	\N	\N	\N	\N	1	2	1	261	\N	\N	0	2020-10-14 03:41:48	2020-10-14 03:41:58	39	1	\N	49	\N	\N	\N
45	022019152	4	7	\N	20008123455	0001804648904	229/OBP-HCM/SPK/I/2020	2019-10-09 00:00:00	2020-01-09	2021-01-08	\N	\N	\N	\N	\N	1	2	1	263	\N	\N	0	2020-10-14 03:43:16	2020-10-14 03:43:35	40	1	\N	31	\N	\N	\N
48	022019159	6	7	\N	20008123430	0001454636834	217/OBP-HCM/SPK/I/2020	2020-01-01 00:00:00	2020-01-01	2020-12-31	\N	\N	\N	\N	\N	1	2	1	277	\N	\N	0	2020-10-14 03:54:12	2020-10-14 03:54:23	43	1	\N	30	\N	\N	\N
49	022019162	10	8	\N	20008123505	0001373380784	212/OBP-HCM/SPK/I/2020	2019-09-02 00:00:00	2020-01-01	2020-12-31	\N	\N	\N	\N	\N	1	2	1	305	\N	\N	0	2020-10-14 03:56:05	2020-10-14 03:56:14	44	1	\N	38	\N	\N	\N
50	022019164	4	9	\N	20001163813	PBI (PEMPROV DKI JAKARTA)	191/OBP-HCM/SPK/XII/2019	2019-09-02 00:00:00	2019-12-02	2020-12-01	\N	\N	\N	02/06/2020	31/12/2020	1	2	1	304	\N	\N	0	2020-10-14 03:58:00	2020-10-14 03:58:08	45	1	\N	45	\N	\N	\N
51	022019176	6	7	\N	20008123471	0001654525506	219/OBP-HCM/SPK/I/2020	2020-01-01 00:00:00	2020-01-01	2020-12-31	\N	\N	\N	\N	\N	1	2	1	296	\N	\N	0	2020-10-14 03:59:47	2020-10-14 03:59:55	46	1	\N	30	\N	\N	\N
52	022019178	11	8	\N	19032578528	PBI (APBN)	176/OBP-HCM/SPK/IX/2019	2019-01-02 00:00:00	2019-09-02	2020-09-01	\N	\N	\N	\N	\N	1	2	1	201	\N	\N	0	2020-10-14 04:01:14	2020-10-14 04:01:23	47	1	\N	4	\N	\N	\N
54	022019184	11	6	\N	20016621474	0002356885967	196/OBP-HCM/SPK/X/2019	2019-10-14 00:00:00	2019-10-14	2020-10-13	\N	\N	\N	\N	\N	1	2	1	345	\N	\N	0	2020-10-14 08:07:24	2020-10-14 08:07:31	49	1	\N	29	\N	\N	\N
55	022019185	11	9	\N	20016621490	0002458624645	197/OBP-HCM/SPK/X/2019	2019-10-21 00:00:00	2019-10-21	2020-10-20	\N	\N	\N	\N	\N	1	2	1	348	\N	\N	0	2020-10-14 08:09:48	2020-10-14 08:09:56	50	1	\N	12	\N	\N	\N
56	022019187	11	7	\N	17050202443	0001125713147	183/OBP-HCM/SPK/X/2019	2019-10-25 00:00:00	2019-10-25	2020-10-24	\N	\N	\N	\N	\N	3	2	1	81	\N	\N	0	2020-10-14 08:11:15	2020-10-14 08:11:35	51	1	\N	18	\N	\N	\N
34	022020020	11	3	\N	19048410278	0001658839498	256/OBP-HCM/SPK/VI/2020	2019-01-16 00:00:00	2020-06-01	2021-05-31	1	8	28	\N	\N	2	2	1	206	\N	\N	0	2020-10-14 02:34:26	2020-10-14 02:34:26	29	1	\N	53	\N	\N	\N
35	022020021	10	1	\N	19041591942	0001616382066	255/OBP-HCM/SPK/V/2020	2019-01-06 00:00:00	2020-05-06	2021-05-05	1	8	7	\N	\N	2	2	1	209	\N	\N	0	2020-10-14 02:36:28	2020-10-14 02:36:28	30	1	\N	51	\N	\N	\N
53	022019179	11	9	\N	20008123497	0000060088511	221/OBP-HCM/SPK/I/2020	2020-01-01	2020-01-01	2020-12-31	\N	\N	\N	\N	\N	1	2	1	336	\N	\N	0	2020-10-14 04:04:02	2021-01-05 04:05:10	48	0	\N	10	\N	\N	\N
37	022019118	11	9	\N	19055178834	0001736937641	264/OBP-HCM/SPK/VII/2020	2019-04-01 00:00:00	2020-07-01	2021-05-30	\N	\N	\N	\N	\N	1	2	\N	225	0	0	0	2020-10-14 03:13:44	2020-10-14 03:15:54	32	1	\N	6	\N	\N	\N
59	022019193	11	9	\N	\N	0002923799782	202/OBP-HCM/SPK/XI/2019	2019-11-11 00:00:00	2019-11-11	2020-11-10	\N	\N	\N	11/05/2020	10/08/2020	1	2	1	355	\N	\N	0	2020-10-14 08:17:16	2020-10-14 08:17:24	54	1	\N	44	\N	\N	\N
60	022019195	4	9	\N	20016621482	PNS	204/OBP-HCM/SPK/XI/2019	2019-11-15 00:00:00	2019-11-15	2020-11-14	\N	\N	\N	15/05/2020	14/11/2020	1	2	1	357	\N	\N	0	2020-10-14 08:18:51	2020-10-14 08:18:59	55	1	\N	45	\N	\N	\N
61	022019196	11	8	\N	20024357525	0002924008986	205/OBP-HCM/SPK/XI/2019	2019-12-02 00:00:00	2019-12-02	2020-12-01	\N	\N	\N	\N	\N	1	2	1	358	\N	\N	0	2020-10-14 08:20:05	2020-10-14 08:20:15	56	1	\N	38	\N	\N	\N
62	022019197	11	3	\N	20024357517	0000041956896	206/OBP-HCM/SPK/XI/2019	2019-12-16 00:00:00	2019-12-16	2020-12-15	\N	\N	\N	\N	\N	1	2	1	360	\N	\N	0	2020-10-14 08:22:39	2020-10-14 08:22:48	57	1	\N	3	\N	\N	\N
63	022019199	6	7	\N	20029754536	0002932578202	220/OBP-HCM/SPK/I/2020	2020-01-01 00:00:00	2020-01-01	2020-12-31	\N	\N	\N	\N	\N	1	2	1	362	\N	\N	0	2020-10-14 08:24:03	2020-10-14 08:24:11	58	1	\N	30	\N	\N	\N
64	022020201	6	7	\N	20008123513	PBI (APBN)	224/OBP-HCM/SPK/I/2020	2020-01-01 00:00:00	2020-01-01	2020-12-31	\N	\N	\N	\N	\N	1	2	1	383	\N	\N	0	2020-10-15 02:07:50	2020-10-15 02:08:01	59	1	\N	30	\N	\N	\N
65	022020204	6	7	\N	20029755988	0001107581163	228/OBP-HCM/SPK/I/2020	2020-01-08 00:00:00	2020-01-08	2021-01-07	\N	\N	\N	\N	\N	1	2	1	365	\N	\N	0	2020-10-15 02:09:37	2020-10-15 02:09:46	60	1	\N	14	\N	\N	\N
66	022020205	11	7	\N	20034285872	0001635190839	231/OBP-HCM/SPK/I/2020	2020-01-13 00:00:00	2020-01-13	2021-01-12	\N	\N	\N	\N	\N	1	2	1	366	\N	\N	0	2020-10-15 02:11:13	2020-10-15 02:11:22	61	1	\N	15	\N	\N	\N
67	022020206	6	7	\N	20029755749	0001129223057	232/OBP-HCM/SPK/I/2020	2020-01-13 00:00:00	2020-01-13	2021-01-12	\N	\N	\N	\N	\N	1	2	1	367	\N	\N	0	2020-10-15 02:13:09	2020-10-15 02:13:19	62	1	\N	24	\N	\N	\N
68	022020208	6	7	\N	17021776046	0002076153131	234/OBP-HCM/SPK/II/2020	2016-01-01 00:00:00	2020-02-01	2021-01-31	\N	\N	\N	\N	\N	3	2	1	398	\N	\N	0	2020-10-15 02:15:08	2020-10-15 02:15:17	63	1	\N	14	\N	\N	\N
69	022020209	10	9	enjang@olympic-development.com	18056501432	0002356440759	235/OBP-HCM/SPK/II/2020	2018-04-02 00:00:00	2020-02-01	2022-01-31	\N	\N	\N	\N	\N	3	2	2	138	\N	\N	0	2020-10-15 02:16:55	2020-10-15 02:17:02	64	1	\N	22	\N	\N	\N
70	022020212	6	9	\N	20040818070	0001722763056	239/OBP-HCM/SPK/I/2020	2020-01-22 00:00:00	2020-01-22	2021-01-21	\N	\N	\N	\N	\N	1	2	1	370	\N	\N	0	2020-10-15 02:18:41	2020-10-15 02:18:51	65	1	\N	34	\N	\N	\N
71	022020213	10	8	\N	17059467906	0001863868252	240/OBP-HCM/SPK/I/2020	2017-08-01 00:00:00	2020-01-01	2020-12-31	\N	\N	\N	\N	\N	1	2	1	68	\N	\N	0	2020-10-15 02:20:08	2020-10-15 02:20:18	66	1	\N	36	\N	\N	\N
72	022020214	11	9	\N	\N	0001440097841	241/OBP-HCM/SPK/II/2020	2020-02-01 00:00:00	2020-02-01	2021-01-31	\N	\N	\N	01/06/2020	31/08/2020	1	2	1	372	\N	\N	0	2020-10-15 02:23:23	2020-10-15 02:23:31	67	1	\N	44	\N	\N	\N
74	022020217	11	9	\N	\N	0002328725136	244/OBP-HCM/SPK/II/2020	2020-02-11 00:00:00	2020-02-11	2021-02-10	\N	\N	\N	11/05/2020	10/08/2020	1	2	1	375	\N	\N	0	2020-10-15 02:34:36	2020-10-15 02:34:43	69	1	\N	44	\N	\N	\N
75	022020218	11	1	adhithia@olympic-development.com	18009603376	0002144053269	245/OBP-HCM/SPK/III/2020	2017-11-01 00:00:00	2020-03-01	2021-02-28	\N	\N	\N	\N	\N	3	2	1	96	\N	\N	0	2020-10-15 02:37:01	2020-10-15 02:37:10	70	1	\N	7	\N	\N	\N
76	022020219	10	7	wulan@olympic-development.com	17021775790	0002103575703	246/OBP-HCM/SPK/III/2020	2016-12-01 00:00:00	2020-03-16	2021-03-15	\N	\N	\N	\N	\N	3	2	1	40	\N	\N	0	2020-10-15 02:38:24	2020-10-15 02:38:33	71	1	\N	11	\N	\N	\N
77	022020220	4	9	\N	20040818088	0001636111653	247/OBP-HCM/SPK/III/2020	2020-03-02 00:00:00	2020-03-02	2021-02-28	\N	\N	\N	01/05/2020	30/11/2020	1	2	1	376	\N	\N	0	2020-10-15 02:40:23	2020-10-15 02:40:31	72	1	\N	45	\N	\N	\N
78	022020221	3	9	\N	20040818062	0001474063751	248/OBP-HCM/SPK/III/2020	2020-03-02 00:00:00	2020-03-02	2021-02-28	\N	\N	\N	\N	\N	1	2	1	377	\N	\N	0	2020-10-15 02:41:59	2020-10-15 02:42:07	73	1	\N	20	\N	\N	\N
79	022020223	3	1	hendrik.indra@olympic-development.com	18017246135	0001621312784	250/OBP-HCM/SPK/IV/2020	2017-12-05 00:00:00	2020-04-06	2021-04-05	\N	\N	\N	\N	\N	3	2	1	98	\N	\N	0	2020-10-15 02:47:53	2020-10-15 02:48:02	74	1	\N	9	\N	\N	\N
80	022020224	11	9	saepulloh@olympic-development.com	20040818096	0002278234528	253/OBP-HCM/SPK/V/2020	2020-05-01 00:00:00	2020-05-01	2021-04-30	\N	\N	\N	\N	\N	1	2	1	64	\N	\N	0	2020-10-15 02:50:33	2020-10-15 02:50:43	75	1	\N	21	\N	\N	\N
81	022020225	6	7	\N	18028160218	0001627202902	254/OBP-HCM/SPK/V/2020	2018-01-17 00:00:00	2020-05-18	2021-05-17	\N	\N	\N	\N	\N	3	2	1	116	\N	\N	0	2020-10-15 02:51:56	2020-10-15 02:52:08	76	1	\N	24	\N	\N	\N
83	022020227	4	9	\N	\N	\N	261/OBP-HCM/SPK/VI/2020	2020-06-02 00:00:00	2020-06-02	2021-06-01	\N	\N	\N	02/06/2020	01/09/2020	1	2	1	382	\N	\N	0	2020-10-15 02:55:20	2020-10-15 02:55:28	78	1	\N	35	\N	\N	\N
84	022020228	11	9	\N	19032249179	0001640566967	262/OBP-HCM/SPK/VI/2020	2020-06-05 00:00:00	2020-06-05	2021-06-04	\N	\N	\N	05/06/2020	04/09/2020	1	2	1	189	\N	\N	0	2020-10-15 02:56:52	2020-10-15 02:57:13	79	1	\N	44	\N	\N	\N
85	022020229	4	8	\N	18041046758	0001635681126	263/OBP-HCM/SPK/VII/2020	2018-03-01 00:00:00	2019-07-01	2021-06-30	\N	\N	\N	\N	\N	3	2	1	124	\N	\N	0	2020-10-15 02:58:24	2020-10-15 02:58:35	80	1	\N	41	\N	\N	\N
86	022020230	6	7	\N	18115520381	0002493029542	265/OBP-HCM/SPK/VII/2020	2018-09-03 00:00:00	2020-07-01	2021-06-30	\N	\N	\N	\N	\N	3	2	1	174	\N	\N	0	2020-10-15 03:00:02	2020-10-15 03:00:10	81	1	\N	24	\N	\N	\N
87	022020231	10	3	nadia@olympic-development.com	17032212866	0001668122594	266/OBP-HCM/SPK/VII/2020	2017-03-29 00:00:00	2020-07-29	2021-07-28	\N	\N	\N	\N	\N	3	2	1	24	\N	\N	0	2020-10-15 03:01:48	2020-10-15 03:02:06	82	1	\N	1	\N	\N	\N
88	022020232	6	7	\N	\N	\N	267/OBP-HCM/SPK/VI/2020	2020-06-26 00:00:00	2020-06-26	2021-06-25	\N	\N	\N	26/06/2020	25/09/2020	1	2	1	384	\N	\N	0	2020-10-15 03:04:58	2020-10-15 03:05:06	83	1	\N	24	\N	\N	\N
89	022020233	6	7	\N	\N	\N	268/OBP-HCM/SPK/VI/2020	2020-06-29 00:00:00	2020-06-29	2021-06-28	\N	\N	\N	29/06/2020	29/09/2020	1	2	1	385	\N	\N	0	2020-10-15 03:07:10	2020-10-15 03:07:22	84	1	\N	30	\N	\N	\N
92	022020236	11	9	\N	\N	\N	271/OBP-HCM/SPK/VII/2020	2020-07-01 00:00:00	2020-07-01	2021-06-30	\N	\N	\N	01/07/2020	30/09/2020	1	2	1	389	\N	\N	0	2020-10-15 03:12:31	2020-10-15 03:12:38	87	1	\N	44	\N	\N	\N
94	022020238	11	9	\N	\N	\N	273/OBP-HCM/SPK/VII/2020	2020-07-01 00:00:00	2020-07-01	2021-06-30	\N	\N	\N	01/07/2020	30/09/2020	1	2	1	392	\N	\N	0	2020-10-15 03:16:08	2020-10-15 03:16:27	89	1	\N	44	\N	\N	\N
36	022020022	10	7	niko@ocbd.co.id	19041591934	0002452759841	257/OBP-HCM/SPK/V/2020	2019-02-06	2020-05-06	2021-05-05	1	8	7	\N	\N	2	2	0	212	\N	\N	0	2020-10-14 02:38:49	2021-04-05 04:47:01	31	1	\N	19	10	\N	1
95	022020239	6	7	\N	\N	\N	\N	2020-07-05 00:00:00	2020-07-05	2020-07-04	\N	\N	\N	05/07/2020	04/10/2020	1	2	1	395	\N	\N	0	2020-10-15 03:18:25	2020-10-15 03:18:34	90	1	\N	24	\N	\N	\N
97	022020241	11	9	\N	\N	\N	\N	2020-07-06 00:00:00	2020-07-06	2021-07-05	\N	\N	\N	06/07/2020	05/10/2020	1	2	1	391	\N	\N	0	2020-10-15 03:22:00	2020-10-15 03:22:22	92	1	\N	48	\N	\N	\N
91	022020235	11	9	\N	\N	\N	270/OBP-HCM/SPK/VII/2020	2020-07-01	2020-07-01	2021-06-30	\N	\N	\N	01/07/2020	30/09/2020	1	2	1	387	\N	\N	0	2020-10-15 03:10:47	2020-12-18 07:45:13	86	0	\N	44	\N	\N	\N
90	022020234	11	9	\N	\N	\N	269/OBP-HCM/SPK/VII/2020	2020-07-01	2020-07-01	2021-06-30	\N	\N	\N	01/07/2020	30/09/2020	1	2	1	386	\N	\N	0	2020-10-15 03:09:05	2020-12-18 07:45:55	85	0	\N	44	\N	\N	\N
73	022020215	11	9	\N	\N	0002935708795	242/OBP-HCM/SPK/II/2020	2020-02-04	2020-02-04	2021-02-03	\N	\N	\N	04/06/2020	03/09/2020	1	2	1	373	\N	\N	0	2020-10-15 02:30:15	2020-12-18 07:46:52	68	0	\N	44	\N	\N	\N
93	022020237	11	9	\N	\N	\N	272/OBP-HCM/SPK/VII/2020	2020-07-01	2020-07-01	2021-06-30	\N	\N	\N	01/07/2020	30/09/2020	1	2	1	390	\N	\N	0	2020-10-15 03:13:59	2020-12-18 07:47:58	88	0	\N	44	\N	\N	\N
96	022020240	4	9	\N	\N	\N	\N	2020-07-06	2020-07-06	2021-07-05	\N	\N	\N	06/07/2020	05/10/2020	1	2	1	388	\N	\N	0	2020-10-15 03:20:20	2020-12-18 07:49:00	91	0	\N	45	\N	\N	\N
57	022019188	11	1	\N	20016621466	0001863344452	198/OBP-HCM/SPK/X/2019	2019-10-28 00:00:00	2019-10-28	2020-10-27	\N	\N	\N	\N	\N	1	2	1	350	\N	\N	0	2020-10-14 08:12:45	2020-10-14 08:12:54	52	1	\N	37	\N	\N	\N
58	022019192	11	9	\N	\N	0002037773586	201/OBP-HCM/SPK/XI/2019	2019-11-11 00:00:00	2019-11-11	2020-11-10	\N	\N	\N	11/05/2020	10/08/2020	1	2	1	354	\N	\N	0	2020-10-14 08:15:21	2020-10-14 08:15:34	53	1	\N	48	\N	\N	\N
19	022016012	4	3	shelly.maryanti@olympic-development.com	17021775915	0002103575714	188/OBP-HCM/SPK/XII/2019	2016-09-19 00:00:00	2019-12-19	2020-12-18	4	\N	23	\N	\N	2	2	1	23	\N	\N	0	2020-10-13 07:18:14	2020-10-13 07:30:19	14	1	\N	17	\N	\N	\N
100	022020086	6	7	\N	\N	\N	\N	2020-08-25 00:00:00	2020-08-25	2021-08-24	\N	\N	\N	25/08/2020	24/11/2020	1	2	1	\N	\N	\N	0	2020-10-15 03:28:46	2020-10-15 03:28:46	95	1	\N	30	\N	\N	\N
101	022020246	11	9	\N	\N	\N	283/OBP-HCM/SPK/IX/2020	2020-09-01 00:00:00	2020-09-01	2021-08-31	\N	\N	\N	01/09/2020	30/11/2020	1	2	1	94	\N	\N	0	2020-10-15 07:11:56	2020-10-15 07:25:24	96	1	\N	44	\N	\N	\N
102	022020247	11	9	\N	920118767313	\N	289/OBP-HCM/SPK/X/2020	2020-10-06	2020-10-06	2021-10-05	\N	\N	\N	\N	\N	1	2	1	402	\N	\N	\N	2020-11-26 08:06:50	2020-11-26 08:07:20	97	1	\N	44	\N	\N	\N
98	022020242	11	9	\N	\N	\N	\N	2020-07-06	2020-07-06	2021-07-05	\N	\N	\N	06/07/2020	05/10/2020	1	2	1	394	\N	\N	0	2020-10-15 03:23:54	2020-12-18 07:43:07	93	0	\N	44	\N	\N	\N
82	022020226	11	9	\N	\N	\N	258/OBP-HCM/SPK/V/2020	2020-05-29	2020-05-29	2021-05-28	\N	\N	\N	29/05/2020	28/08/2020	1	2	1	381	\N	\N	0	2020-10-15 02:53:43	2020-12-18 07:44:25	77	0	\N	44	\N	\N	\N
47	022019157	6	7	\N	20008123489	0002913026128	216/OBP-HCM/SPK/I/2020	2020-01-01	2020-01-01	2020-12-31	\N	\N	\N	\N	\N	1	2	1	274	\N	\N	0	2020-10-14 03:52:52	2021-01-05 04:04:33	42	0	\N	30	\N	\N	\N
15	022015001	1	7	virthonh@olympic-development.com	15040847715	0001648815884	\N	2018-08-28	\N	\N	2	1	16	\N	\N	0	3	0	\N	\N	\N	1	2020-10-13 06:57:56	2021-03-19 02:44:11	10	1	\N	33	\N	\N	1
99	022020243	11	7	\N	\N	\N	\N	2020-07-20	2020-07-20	2021-07-19	\N	\N	\N	20/07/2020	19/10/2020	1	2	1	397	\N	\N	0	2020-10-15 03:25:56	2021-03-19 03:09:31	94	1	\N	28	31	10	1
\.


--
-- TOC entry 3086 (class 0 OID 53265)
-- Dependencies: 215
-- Data for Name: tabel_karyawan_file; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_karyawan_file (id_karyawanfile, judul, keterangan, created_at, updated_at, id_karyawan_personal, file) FROM stdin;
17	foto	tes	2020-11-26 07:45:33	2020-11-26 07:45:33	10	1606376733ocbd.jpg
18	kk	\N	2020-11-26 07:48:36	2020-11-26 07:48:36	26	1606376916Kartu Keluarga Mukhmad Imammudin.pdf
19	lain	CV	2020-11-26 07:49:20	2020-11-26 07:49:20	26	1606376960Kartu Keluarga Mukhmad Imammudin.pdf
\.


--
-- TOC entry 3088 (class 0 OID 53276)
-- Dependencies: 217
-- Data for Name: tabel_karyawan_keluarga; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_karyawan_keluarga (id_karyawankeluarga, nama, tgl_lahir, status_keluarga, keterangan, no_kontak, created_at, updated_at, id_karyawan_personal) FROM stdin;
\.


--
-- TOC entry 3090 (class 0 OID 53287)
-- Dependencies: 219
-- Data for Name: tabel_karyawan_pekerjaan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_karyawan_pekerjaan (id_karyawanpekerjaan, pekerjaan, bidang, instansi, tahun_masuk, tahun_keluar, keterangan, created_at, updated_at, id_karyawan_personal) FROM stdin;
\.


--
-- TOC entry 3092 (class 0 OID 53298)
-- Dependencies: 221
-- Data for Name: tabel_karyawan_pendidikan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_karyawan_pendidikan (id_karyawanpendidikan, tingkat_pendidikan, nama_sekolah, jurusan, kota, nilai_akhir, tahun_lulus, created_at, updated_at, id_karyawan_personal) FROM stdin;
\.


--
-- TOC entry 3082 (class 0 OID 53220)
-- Dependencies: 211
-- Data for Name: tabel_karyawan_personal; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_karyawan_personal (nama_lengkap, tempatlahir, tgllahir, jk, suku, agama, status, alamatktp, kodeposktp, foto, no_kk, no_ktp, no_telepon, no_hp, email_pribadi, alamat_domisili, hobi, npwp, norek_tabungan, bank_tabungan, created_at, updated_at, id_karyawan_personal, status_pegawai, status_loginakun) FROM stdin;
Shelly Maryanti	Jambi	07 Agustus 1994	P	\N	12	K1	Perumahan Muara Asri No 38D Rt 03/ Rw 12 Kel Pasirkuda Kec Bogor Barat	\N	\N	3271012307190017	3271044708940003	02518347470	085210068333	\N	Perumahan Muara Asri No 38D Rt 03/ Rw 12 Kel Pasirkuda Kec Bogor Barat	\N	748460144404000	4278004366	BCA	2020-10-13 02:44:46	2020-10-13 02:44:46	14	1	\N
Wahyuningsih	Kediri	09 Januari 1977	P	jawa	1	K1	Jl Pramuka Kompl Al No 11 Rt 14/ 08 Kel Rawasari Kec Cempaka Putih	\N	\N	\N	3171054901770003	\N	081357497646	\N	Perum Kota Wisata, Cluster Calgary Blok Ue 5 No. 32	Baca,Olahraga	874530207003000	0953763301	BCA	2020-10-13 02:46:45	2020-10-13 02:46:45	15	1	\N
Angga Eka Putra	Bogor	15 Juli 1983	L	sunda	1	K2	Kp. Rawa Rt 02 Rw 02 Kel. Gadog Kec. Megamendung, Kab. Bogor	\N	\N	3201261409110010	3201261507830022	\N	0895377809071	ghaw.genfrust46@gmail.com	Jl. Raya Puncak Gadog Kp. Rawa Rt 02 Rw 02 Kel. Gadog Kec.Megamendung, Kab. Bogor	Olah Raga	458814209434000	0953765575	BCA	2020-10-13 02:51:51	2020-10-13 02:51:51	17	1	\N
Sandro Marcelino Damanik	Palembang	21 September 1983	L	batak	3	K	Jl. Sonokeling Raya No. 179 A Rt 04/15 Kel. Baktijaya Kec. Sukmajaya Kota Depok	16418	\N	3276052508100012	3276052109830007	\N	081369004602	mandromarcelino@yahoo.com	Vila Bogor Indah 3 Blok Ab2/14, Rt 06/15 Kel. Kedung Halang Kec. Bogor Utara Kota Bogor	Membaca	256833724412000	0953762959	BCA	2020-10-13 02:55:06	2020-10-13 02:55:06	18	1	\N
Akhmad Zaki Firdaus	Depok	05 Agustus 1996	L	betawi	1	BK	Jl. Menteng Ii No. 1 Rt 02 / 03 Kel Beji Timur Kec. Beji Kota Depok	16422	\N	3276061711070250	3276060508960002	\N	081284949030	zakhmad5@gmail.com	Jl. Menteng Ii No. 1 Rt 02 / 03 Kel Beji Timur Kec. Beji Kota Depok	Olah Raga	tidak punya	8691535398	BCA	2020-10-13 03:02:33	2020-10-13 03:02:33	19	1	\N
Nina Marlina	Karawang	15 Maret 1986	P	sunda	1	BK	Cimanglid Gg. H. Milo Rt 03/12 Kel. Sirnagalih Kec. Tamansari Kabupaten Bogor	\N	\N	3201310708080006	3201315503860001	\N	081386925009	amaruynha00.an@gmail.com	Cimanglid Gg. H. Milo Rt 03/12 Kel. Sirnagalih Kec. Tamansari Kabupaten Bogor	\N	664588977434000	0953437055	BCA	2020-10-13 03:04:17	2020-10-13 03:04:17	20	1	\N
Agus Setiawan	Soreang	13 Desember 1988	L	sunda	1	BK	Kp. Bojong Citeupus Rt 06 /09 Kel. Cangkuang Wetan Kec. Dayeuhkolot Kab. Bandung	\N	\N	3204123005110114	3204121312880008	\N	081221181026	setiawanagusrf8891@gmail.com	Kp. Bojong Citeupus Rt 06 /09 Kel. Cangkuang Wetan Kec. Dayeuhkolot Kab. Bandung	\N	771180379445000	7380544983	BCA	2020-10-13 03:06:26	2020-10-13 03:06:26	21	1	\N
Suhartin Ekafacksi	Jakarta	14 April 1989	P	jawa	1	K1	Jl. Krakatau VI No 276 RT 09/09 Kel. Abadijaya Kec. Sukmajaya Kota Depok	16417	\N	3276051111150010	3175055404890008	\N	087780878348	eka.facksi@yahoo.com	Jl. Swadaya Raya, Kp. Muara Beres RT 02 RW 04 Kel. Sukahati Kec. Cibinong, Kab Bogor	Membaca	458481207009000	4661323030	BCA	2020-10-13 03:08:00	2020-10-13 03:08:00	22	1	\N
Norman Edward Sebastian	Jakarta	04 Maret 1983	L	\N	12	K2	Taman Kebon Jeruk Blok G1/95 Rt 02/11 Kel Srengseng Kec Kembangan, Kota Jakarta Barat	\N	\N	3173081001091618	3173080403830005	\N	\N	nsebastian@pt-nes.com	\N	\N	\N	0840574440	BCA	2020-10-13 03:08:56	2020-10-13 03:08:56	23	1	\N
Panggih Kurnianto, S.T.	Magelang	23 Desember 1989	L	jawa	12	K1	Semanggi Rt 06 Rw 09 Kel. Semanggi Kec. Pasar Kliwon Kota Surakarta	57117	\N	3372031401160006	3371012312890003	\N	081250194594	panggih.kurnianto@gmail.com	Semanggi Rt 06 Rw 09 Kel. Semanggi Kec. Pasar Kliwon Kota Surakarta	\N	736195793524000	0097081313	BCA	2020-10-13 03:10:24	2020-10-13 03:10:24	24	1	\N
Nizar Alfarizy	Surabaya	13 April 1990	L	jawa	1	BK	Dsn. Pilangbangu Rt 01 Rw 03 Kel. Tarokan Kec. Tarokan Kabupaten Kediri	64152	\N	3506202707120053	3506201304900003	\N	0816931273	nizaralfarizy13@yahoo.com	Jl. Sukaraja No29 Kel Cadas Ngampar Kec. Sukaraja Kab. Bogor	Olah Raga	708409107655000	5735158993	BCA	2020-10-13 03:13:21	2020-10-13 03:13:21	25	1	\N
Mukhamad Imammudin	Bogor	03 Juni 1995	L	sunda	1	K1	Jl. Perkesa Kav DPRD No. 1 RT 01 RW 18 Kel. Cipaku  Kec. Lota Bogor Selatan	16133	\N	3271012410170017	3271010306950017	\N	085887236279	imammudin735@gmail.com	Jl. Perkesa Kav DPRD No. 1 RT 01 RW 18 Kel. Cipaku  Kec. Lota Bogor Selatan	Olah Raga	985411214404000	0953295340	BCA	2020-10-13 03:14:50	2020-10-13 03:14:50	26	1	\N
Femmy Tantiana	Bogor	17 Maret 1987	P	sunda	1	K1	Jl Arzimar Ii No 20 Rt 05/02 Gg Mesjid Kel Tegal Gundil Kec Bantarjati - Kota Bogor	16152	\N	3271051308150010	3271055703870007	(0251) 8316352	081311150523, 087770621665	fe.sakhi@yahoo.co.id	Jl Arzimar Ii No 20 Rt 05/02 Gg Mesjid Kel Tegal Gundil Kec Bantarjati - Kota Bogor	\N	249125519404000	0953460626	BCA	2020-10-13 03:16:04	2020-10-13 03:16:04	27	1	\N
Sartika Puji Astuti	Bogor	26 September 1995	P	sunda	1	K1	Jl. Sempur Kaler Blok II /1 RT 05 RW 01 Kel. Sempur Kec. Kota Bogor Tengah Kota Bogor	\N	\N	\N	3201046609950002	\N	081218440339	sartikafujiastuti@gmail.com	\N	Bernyayi	703640870403000	\N	BCA	2020-10-13 03:17:19	2020-10-13 03:17:19	28	1	\N
Derin Romalia	Bogor	28 Maret 1991	P	sunda	1	KI	Kampung Sawah RT 01 RW 11 Kel. Cibinong Kec. Cibinong Kab. Bogor	16911	\N	3201010202160044	3201016803910004	\N	081321205115	derinromalia@gmail.com	Kampung Sawah RT 01 RW 11 Kel. Cibinong Kec. Cibinong Kab. Bogor	\N	479081994403000	0845119754	BCA	2020-10-13 03:20:17	2020-10-13 03:20:17	29	1	\N
Yusuf Ibrahim	Bogor	02 Februari 1976	L	sunda	1	K4	Ciherang Kidul RT 04 RW 03 Kel. Laladon Kec. Ciomas Kab. Bogor	\N	\N	\N	3201290202760002	\N	081574377383	yusufibrahim96.yi@gmail.com	Ciherang Kidul RT 04 RW 03 Kel. Laladon Kec. Ciomas Kab. Bogor	Bulu Tangkis	686713801434000	8720372909	BCA	2020-10-13 03:21:31	2020-10-13 03:21:31	30	1	\N
Virthon Hutagalung	Medan	24 November 1972	L	batak	2	K3	Jln. Pagelaran Asogiri Komp. Tbi Kav 93 No. A2 Rt 03/Rw 04 Kel. Tanah Baru Kec. Bogor Utara	16154	1603768758Pak virthon.jpg	3271050807080028	3271052411720010	\N	08125401232	\N	Jln. Pagelaran Asogiri Komp. Tbi Kav 93 No. A2 Rt 03/Rw 04 Kel. Tanah Baru Kec. Bogor Utara	Musik, Traveling	672565736404000	7380538797	BCA	2020-10-13 02:29:09	2020-10-27 03:19:18	10	1	\N
Luqman Al Hakim	Depok	14 Juni 1987	L	sunda	1	K1	Kp. Sengon Rt 10 Rw 10 No 52 Kec. Pancoranmas Kel. Pancoranmas Kota Depok	16436	\N	3276011902160017	3276011406870008	\N	081287822445	luqman1406@gmail.com	Kp. Sengon Rt 10 Rw 10 No 52 Kec. Pancoranmas Kel. Pancoranmas Kota Depok	Olah Raga	256659566412000	6040862861	BCA	2020-10-13 03:30:25	2020-10-13 03:30:25	32	1	\N
Eka Surya Wijaya	Bogor	24 Juni 1968	L	\N	12	K2	Bukit Nirwana I No. 189 Bnr Rt 04 Rw 12 Kel. Mulyaharja Kec. Kota Bogor Selatan	\N	1606378972pak eka.jpg	3271011207120005	3271012406680002	\N	0811873081	\N	Bukit Nirwana I No. 189 Bnr Rt 04 Rw 12 Kel. Mulyaharja Kec. Kota Bogor Selatan	\N	\N	\N	BCA	2020-10-13 02:40:07	2020-11-26 08:22:52	12	1	\N
Imelda Fransisca	Bogor	24 September 1982	P	\N	12	K2	Taman Kebon Jeruk Blok G1/95 Rt 02/11 Kel Srengseng Kec Kembangan, Kota Jakarta Barat	\N	1606379023_MG_1110.JPG	3173081001091618	3173086409820001	\N	0811110122	\N	\N	\N	092238781404000	5005009119	BCA	2020-10-13 02:42:52	2020-11-26 08:23:43	13	1	\N
Ardian Hary Sudarto	Bogor	05 Mei 1997	L	jawa	1	BK	Jl. MT. Haryono No. 58 RT 17 RW 06 Kel. SumberGedong Kec. Trenggalek Kab. Trenggalek	66315	\N	3503110907090001	3503110505970004	\N	082232249793	ardianhary@gmail.com	Taman Tampak Siring IX No. 29 Sentul City	Olah Raga	tidak punya	1131246132	BCA	2020-10-13 03:31:39	2020-10-13 03:31:39	33	1	\N
Aoedronick Todo P. Siagian ST	Cimahi	30 April 1984	L	batak	2	K1	Kav. DPRD  DKI BLK H21 RT 11 RW 07 Kel Cibubur Kec. Ciracas Jakarta Timur	\N	\N	3175092502151016	3175093004840005	\N	088210381050	aoedronick@gmail.com	Kav. DPRD  DKI BLK H21 RT 11 RW 07 Kel Cibubur Kec. Ciracas Jakarta Timur	travelling	249158221009000	8410422787	BCA	2020-10-13 03:33:25	2020-10-13 03:33:25	34	1	\N
Andi Ayuh Ardana Reswary	Bantaeng	08 Juni 1989	P	bugis	1	BK	Jl. Raya Lanto No.37 RT 02 RW 06 Kel. Tappanjeng Kec. Bantaeng Kab. Bantang	70654	\N	6303022707170003	7303024806890002	\N	08114100306	ardana.engineer@gmail.com	Kost Kaum Sari Belakang MG	Olah Raga	643701600807000	0373435390	BCA	2020-10-13 03:34:36	2020-10-13 03:34:36	35	1	\N
Wildan Awaludin	Bogor	15 September 1993	L	sunda	1	K1	Kp. Sirnagalih RT 02 RW 03 Kel. Ranggamekar Kec. Kota Bogor Selatan Kota Bogor	\N	\N	\N	3271011509930010	\N	085716390134	wildanawaludin23@gmail.com	Kp. Sirnagalih RT 02 RW 03 Kel. Ranggamekar Kec. Kota Bogor Selatan Kota Bogor	Bermain Bola	tidak punya	4270131714	BCA	2020-10-13 03:35:42	2020-10-13 03:35:42	36	1	\N
Muchlis	Bogor	07 September 1995	L	betawi	1	BK	Kp. Sudimampir RT 04 RW 02 Kel. Cimanggis Kec. Bojong Gede Kab Bogor	\N	\N	\N	3201130709950004	\N	0895355620027	muchlishadhiding599@gmail.com	Kp. Sudimampir RT 04 RW 02 Kel. Cimanggis Kec. Bojong Gede Kab Bogor	Olah Raga	\N	8720459150	BCA	2020-10-13 03:38:42	2020-10-13 03:38:42	37	1	\N
Dina Arsitarely	Bogor	26 Juni 1996	P	jawa	1	BK	Puri Nirwana 1 blok K no. 30 RT 03 RW 16 Kel. Pabuaran Kec. Cibinong Kab. Bogor	16913	\N	3201012808070134	3201016606960005	\N	089534617633	dinaarsitarely@yahoo.com	Puri Nirwana 3 blok AE no. 1 RT 08 RW 14 Kel. Sukahati Kec. Karadenan Kab. Bogor	Travel	842242265403000	1671304522	BCA	2020-10-13 03:41:11	2020-10-13 03:41:11	39	1	\N
Ir. Eko Wiyantono	Jember	26 Oktober 1964	L	jawa	1	K	Jl. Anggrek Bulan No.9 RT 02 RW 09 Kel. Jatimulyo Kec. Lowok Waru Kota Malang	\N	\N	\N	3573052610640001	\N	082210092838	wiyantono71@yahoo.com	\N	\N	252867155401000	7360412827	BCA	2020-10-13 03:46:20	2020-10-13 03:46:20	40	1	\N
Rahmat Kusnanto	Bogor	26 November 1974	L	sunda	1	K2	Sampora RT 05 RW 03 Kel. Cibinong Kec. Cibinong Kab. Bogor	\N	\N	\N	3201012611740002	\N	\N	\N	Sampora RT 05 RW 03 Kel. Cibinong Kec. Cibinong Kab. Bogor	\N	\N	6830590658	BCA	2020-10-13 03:47:41	2020-10-13 03:47:41	41	1	\N
Nurhadi	Cirebon	06 November 1991	L	sunda	1	BK	Dusun III RT 05 RW 01 Kel. Cibogo Kec. Waled Kab. Cirebon	\N	\N	\N	3209010611910008	\N	089637316978	\N	\N	\N	\N	8410485835	BCA	2020-10-13 03:48:32	2020-10-13 03:48:32	42	1	\N
Sumarta	Bogor	02 Februari 1958	L	sunda	1	K3	Kp. Pangkalan RT 01 RW 01 Kel. Cibuluh Kec. Kota Bogor Utara Kota Bogor	\N	\N	\N	3271050202580012	\N	\N	\N	\N	\N	\N	8410485533	BCA	2020-10-13 03:51:09	2020-10-13 03:51:09	43	1	\N
Ryan Andresta Wiguna	Tangerang	16 November 1991	L	betawi	1	K	Jl. Prenja No.17 RT 09 RW 01 Kel. Bukit Duri Kec. Tebet , Jakarta Selatan	\N	\N	\N	3174011611910008	\N	087882842568	ryan.andresta@gmail.com	Jl. Prenja No.17 RT 09 RW 01 Kel. Bukit Duri Kec. Tebet , Jakarta Selatan	Futsal	755474889015000	7380617174	BCA	2020-10-13 03:52:22	2020-10-13 03:52:22	44	1	\N
Rocky Sahid	Jakarta	20 Desember 1981	L	betawi	1	K	Pondok Gading Residence Jl. Lebak Wangi Raya Blok B10 RT 05 RW 02 Kel. Pamagarsari Kec. Parung Kab. Bogor	\N	\N	\N	3173082012810007	\N	08111116233	sahid.property81@gmail.com	Pondok Gading Residence Jl. Lebak Wangi Raya Blok B10 RT 05 RW 02 Kel. Pamagarsari Kec. Parung Kab. Bogor	olah raga	699686986086000	7140141873	BCA	2020-10-13 03:53:36	2020-10-13 03:53:36	45	1	\N
Lukman Nulhakim	Bogor	11 Januari 1980	L	sunda	1	BK	Kp. Kaum Sari RT 03 RW 05 Kel. Cibuluh Kec. Kota Bogor Utara Kota Bogor	\N	\N	\N	3271051101800017	\N	085715672530	\N	Kp. Kaum Sari RT 03 RW 05 Kel. Cibuluh Kec. Kota Bogor Utara Kota Bogor	\N	\N	8410485410	BCA	2020-10-13 03:55:37	2020-10-13 03:55:37	46	1	\N
Mega Nur Fitria	Bogor	27 Agustus 2000	P	sunda	1	BK	Cijujung Tengah RT 04 / 04 Kel. Cijujung Kec. Sukaraja Kabupaten Bogor	16710	\N	3201042901070028	3201046708000008	\N	088290440016	nurfitriamega27@gmail.com	Cijujung Tengah RT 04 / 04 Kel. Cijujung Kec. Sukaraja Kabupaten Bogor	Menggambar	\N	8410406471	BCA	2020-10-13 03:58:34	2020-10-13 03:58:34	47	1	\N
Mochamad Rizki Afrilio	Bogor	15 April 2000	L	sunda	1	BK	Jl. RE. Abdullah No. 10 RT 01 RW 05 Kel. Pasirmulya Kec. Kota Bogor Barat Kota Bogor	\N	\N	\N	3271041504000018	\N	08990653717	afriliorizki99@gmail.com	Pondok Permata Hijau Jl. Mawar no. 20 Ciomas	Membuat Film	\N	6820661662	BCA	2020-10-13 03:59:50	2020-10-13 03:59:50	48	1	\N
Ivan Andrian	Bogor	16 November 1990	L	\N	1	K1	Gg. Kembang RT 04 RW 09 Kel. Kedunghalang Kec. Kota Bogor Utara Kota Bogor	\N	\N	\N	3271051611900002	\N	085694398705	\N	Gg. Kembang RT 04 RW 09 Kel. Kedunghalang Kec. Kota Bogor Utara Kota Bogor	Futsal	731386876404000	8411010473	BCA	2020-10-13 04:01:08	2020-10-13 04:01:08	49	1	\N
Rendy Dwi Putra	Jakarta	02 Mei 1997	L	sunda	1	BK	Jl. Pamoyanan Sari RT 03 RW 01 Kel. Ranggamekar Kec. Kota Bogor Selatan Kota Bogor	\N	\N	3271010204120008	3271010205970019	\N	087770298902	rendydwiputra70@gmail.com	Jl. Pamoyanan Sari RT 03 RW 01 Kel. Ranggamekar Kec. Kota Bogor Selatan Kota Bogor	Design	923347165404000	7600510031	BCA	2020-10-13 04:02:23	2020-10-13 04:02:23	50	1	\N
M. Alit Sanusi	Bogor	17 November 1972	L	sunda	1	K2	Kaum Sari Rt 02 Rw 05 Kel. Cibuluh Kec. Kota Bogor Utara, Kota Bogor	16151	\N	3271050403071792	3271051711720001	\N	087770555093	albysanusi73@gmail.com	Kaum Sari Rt 02 Rw 05 Kel. Cibuluh Kec. Kota Bogor Utara, Kota Bogor	\N	686744186404000	8720310849	BCA	2020-10-13 04:03:47	2020-10-13 04:03:47	51	1	\N
Jeffry Alvianto	Yogyakarta	07 Juli 1997	L	jawa	1	BK	Kp. Tanah Sewa RT 05 RW 03 Kel. Ciparigi Kec. Kota Bogor Utara, Kota Bogor	16157	\N	3271052602074629	3271050707970008	\N	08978647866	jeffryalvian@gmail.com	Kp. Tanah Sewa RT 05 RW 03 Kel. Ciparigi Kec. Kota Bogor Utara, Kota Bogor	olah raga	734401219404000	8410993164	BCA	2020-10-13 04:05:08	2020-10-13 04:05:08	52	1	\N
M. Rizki Maulana	Bogor	06 September 1992	L	sunda	1	K	Perum Puspa Raya Blok FA/18 RT 02 RW 09 Kel. BojongBaru Kec. Bojong Gede Kab. Bogor	\N	\N	\N	3201130609920005	\N	081292624513	muhammadrizky.property@gmail.com	\N	olah raga	660689407403000	\N	BCA	2020-10-13 04:06:25	2020-10-13 04:06:25	53	1	\N
Bepin Zahari	Muara Pulutan	12 Juni 1994	L	\N	1	BK	Perum Vila Asri 2 blok P 23 RT 02 RW 25 Kel. Wanaherang Kec. Gunung Putri Kab. Bogor	\N	\N	\N	1701021206940002	\N	081318440300	bpinzahari@gmail.com	Jl. Bababkan Madang  Sentul Bogor	olah raga	914067434403000	\N	BCA	2020-10-13 04:07:36	2020-10-13 04:07:36	54	1	\N
Marini	Yogyakarta	30 Juni 1981	P	jawa	1	K2	Bukit Cimanggu City Blok U 2/2 RT 05 RW 14 Kel. Cibadak Kec. Tanah Sareal Kota Bogor	16166	\N	3271061109090021	3271067006810015	\N	081218806999	riniharyanto@yahoo.co.id	Bukit Cimanggu City Blok U 2/2 RT 05 RW 14 Kel. Cibadak Kec. Tanah Sareal Kota Bogor	olah raga	892678053404000	1661907491	BCA	2020-10-13 04:08:35	2020-10-13 04:08:35	55	1	\N
Sunardi	Wonogiri	19 Juli 1981	L	jawa	1	K1	Pondok Ungu Permai Blok C 15 RT 15 RW 10 Kel. Kaliabang Tengah Kec. Bekasi Utara Kota Bekasi	\N	\N	\N	3275031907810021	\N	08122645238	sunardi190781@gmail.com	Pondok Ungu Permai Blok C 15 RT 15 RW 10 Kel. Kaliabang Tengah Kec. Bekasi Utara Kota Bekasi	olah raga	359050267407000	8410477913	BCA	2020-10-13 04:11:49	2020-10-13 04:11:49	56	1	\N
Putri Permatasari	Bogor	18 November 1993	P	sunda	1	BK	Lingkungan 01 Ciriung RT 04 RW 03 Kel. Ciriung Kec. Cibinong Kab. Bogor	16917	\N	3201011907074123	3201015811930007	\N	085606182649	putripermatasari1818@gmail.com	Lingkungan 01 Ciriung RT 04 RW 03 Kel. Ciriung Kec. Cibinong Kab. Bogor	Membaca	842607723403000	6830583163	BCA	2020-10-13 04:13:25	2020-10-13 04:13:25	57	1	\N
Farhan Jamil	Bogor	12 April 1989	L	sunda	1	K2	Kp. Kaum Sari RT 02 RW 05 Kel. Cibuluh Kec. Kota Bogor Utara Kota Bogor	16151	\N	\N	3271061204890004	\N	085781366478	jamilfarhan862@gmail.com	Kp. Kaum Sari RT 02 RW 05 Kel. Cibuluh Kec. Kota Bogor Utara Kota Bogor	Olahraga	\N	8410484871	BCA	2020-10-13 04:16:35	2020-10-13 04:16:35	58	1	\N
Ridwan	Sukabumi	01 Agustus 1991	L	sunda	1	K1	Kp. Blok Randu RT 01 RW 03 Kel. Darmareja Kec. Nagrak Kab. Sukabumi	\N	\N	\N	3202120108910007	\N	\N	\N	\N	\N	\N	3520606296	BCA	2020-10-13 04:18:05	2020-10-13 04:18:05	59	1	\N
Ahmad Fauzi Mulyadi	Cianjur	12 April 1994	L	sunda	1	BK	Gg. Bali RT 01 RW 16 Kel. Bojong Herang Kec. Cianjur Kab. Cianjur	43216	\N	3203011511130001	3203011204940020	\N	081296916858	ajidot063@gmail.com	Gg. Bali RT 01 RW 16 Kel. Bojong Herang Kec. Cianjur Kab. Cianjur	Olah Raga	\N	0954081008	BCA	2020-10-13 04:20:33	2020-10-13 04:20:33	60	1	\N
Suci Fitriyanto	Jakarta	05 Juni 1986	L	jawa	1	BK	Perumahan Citra Graha Prima Jl. Rajawali 2 BLO RT 001 RW 013 Kel. Singasari Kec. Jonggol Kab. Bogor	\N	\N	3201060303170003	3172040506860001	\N	081283153040	sucifitriyanto@gmail.com	Perum Citra Graha Prima, Blok R.38-26 RT 001/013	Olah Raga	BCA	\N	4061085453	2020-10-13 04:24:15	2020-10-13 04:24:15	61	1	\N
Ahmad Nawawi	Bogor	08 Oktober 1979	L	sunda	1	K2	Kp. Cibuluh RT 04 RW 08 Kel. Cibuluh Kec. Kota Boogor Utara Kota Bogor	\N	\N	3271052907080056	3271050810790024	\N	085691983050	\N	\N	Olah Raga	\N	8410487943	BCA	2020-10-13 04:25:16	2020-10-13 04:25:16	62	1	\N
Wawan Sugianto	Tegal	11 Juli 1979	L	jawa	1	K3	Dk. Karangsari Rt 03/05 Kel.Sukomulyo Kec. Rowokele Kab. Kebumen	54472	\N	3305171505100002	3305171107790001	\N	087855099816	wawansugianto39@gmai.com	Dk. Karangsari Rt 03/05 Kel.Sukomulyo Kec. Rowokele Kab. Kebumen	Memancing	\N	5005234520	BCA	2020-10-13 04:26:12	2020-10-13 04:26:12	63	1	\N
Enjang Misbah	Tasikmalaya	15 Desember 1975	L	sunda	1	K3	Jl. Batutulis Gg. Balekambang No.113 Rt 001 Rw 004 Kel. Batutulis Kec. Kota Bogor Selatan	\N	\N	\N	3271011512750003	\N	081398826575	enjangmisbah@gmail.com	Jl. Batutulis Gg. Balekambang No.113 Rt 001 Rw 004 Kel. Batutulis Kec. Kota Bogor Selatan	Traveling	681824728404000	8410253811	BCA	2020-10-13 04:27:11	2020-10-13 04:27:11	64	1	\N
Arip Rahman Hidayat	Bogor	02 Mei 1996	L	sunda	1	K1	Sindangbarang RT 05 RW 01 Kel. Sindangbarang Kec. Kota Bogor Barat	16117	\N	3271040412180015	3271040204960002	\N	0895355288199 / 0895350288739	\N	Sindangbarang RT 05 RW 01 Kel. Sindangbarang Kec. Kota Bogor Barat	Sepak Bola	\N	6820870776	BCA	2020-10-13 04:28:03	2020-10-13 04:28:03	65	1	\N
Nurwanto	Banjarnegara	19 Januari 1981	L	jawa	2	K2	Bogor Asri Blok K8-5  Rt 06 / 11 Kel. Nanggewer Kec. Cibinong	\N	\N	\N	3304091901810001	\N	081287984131	brewqclodias@gmail.com	Bogor Asri Blok K8-5  Rt 06 / 11 Kel. Nanggewer Kec. Cibinong	Olah Raga	758724173403000	0953763424	BCA	2020-10-13 04:35:12	2020-10-13 04:35:12	66	1	\N
Erni Afriani	Bogor	20 April 1989	P	sunda	1	C2	Muara Kidul RT 04/11 Kel. Pasir Jaya Kec. Kota Bogor Barat Kota Bogor	\N	\N	\N	3201026404890011	\N	081584860109	\N	Ciomas Permai Blok D5 no. 6	Menari	666635487403000	\N	BCA	2020-10-13 04:36:23	2020-10-13 04:36:23	67	1	\N
Okky Ibrahim Durmawel	Jakarta	13 Oktober 1984	L	betawi	1	K2	Jln. Atletik no. 09 RT 04 RW 02 Kel. Tanah Sareal Kec. Tanah Sareal Kota Bogor	\N	\N	\N	3271061310840005	\N	087885106564	ocky_1013@yahoo.co.id	Jl. Letkol Atang Senjaya No. 20	travelling	702041351404000	\N	BCA	2020-10-13 04:37:22	2020-10-13 04:37:22	68	1	\N
Muhamad Noor	Sukoharjo	16 April 1989	L	jawa	1	K2	Sindang Barang Jero no. 1 RT 06 / RW 07 Kel. SindangBarang Kec. Kota Bogor Barat	\N	\N	\N	3171010604890005	\N	087822571999	noerrifky@gmail.com	Sindang Barang Jero no. 1 RT 06 / RW 07 Kel. SindangBarang Kec. Kota Bogor Barat	Olah Raga	719087157028000	\N	BCA	2020-10-13 04:38:10	2020-10-13 04:38:10	69	1	\N
Adhithia Sigit Purwono	Jakarta	26 November 1993	L	jawa	1	BK	Perum Griya Curug C 5/15 Rt 10 Rw 11 Kel. Rancagong Kec. Legok, Kabupaten Tangerang	15920	\N	3603202109150006	3603172611930004	0215986711	087782515351	sigitadhithia@gmail.com	Perum Griya Curug C 5/15 Rt 10 Rw 11 Kel. Rancagong Kec. Legok, Kabupaten Tangerang	Main Game	722482726451000	0953763556	BCA	2020-10-13 04:39:17	2020-10-13 04:39:17	70	1	\N
Dwi Wulandari	Bogor	16 Mei 1986	P	jawa	3	K2	Jl Kamboja 2 No 03 Rt 07/ 05 Cimanggis Depok	16951	\N	3276020410110050	3276025605860009	\N	081213396461, (WA 081283295086)	\N	Jl Kamboja 2 No 03 Rt 07/ 05 Cimanggis Depok	Traveling	585910102412000	5240314136	BCA	2020-10-13 04:40:22	2020-10-13 04:40:22	71	1	\N
Theodore David P.S	Sawah Lunto	25 Juni 1980	L	batak	12	K3	Jl. Cawang Gg. Tauladan RT 07 RW 12 Kel. Bidara Cina Kec. Jatinegara Jakarta Timur	\N	\N	3175030205121003	3603282506800010	087777786586	081585959525	theodavid.3m@gmail.com	Pesona Calgary UF 4 Kota Wisata Cibubur	Olah Raga	254421225451000	\N	BCA	2020-10-13 04:41:29	2020-10-13 04:41:29	72	1	\N
Meilyana	Jakarta	02 Mei 1973	P	jawa	12	C3	Perum Cenning Ampe Blok M No.1 RT 04 RW 27 Kel. Sukamaju Kec. Cilodong Kota Depok	16415	\N	3276050602080026	3276054205730006	\N	08111111781	meil_yana@ymail.com	Perum Cenning Ampe Blok M No.1 RT 04 RW 27 Kel. Sukamaju Kec. Cilodong Kota Depok	Olah Raga	672422607412000	6460173033	BCA	2020-10-13 04:42:29	2020-10-13 04:42:29	73	1	\N
Hendrik Indra	Medan	22 Agustus 1974	L	tapanuli	12	K4	Kp. Biru No. 237 Rt 002/ 004 Kel. Dago Kec. Coblong Kota Bandung	\N	\N	\N	3273022208740012	\N	081808033714	peiterjoh@gmail.com	Jl. Pangeran Antasari No 36 Jakarta Selatan	\N	574908737423000	6220328412	BCA	2020-10-13 04:43:25	2020-10-13 04:43:25	74	1	\N
Asep Saepulloh	Bogor	09 September 1989	L	sunda	1	BK	Jl. Parung Banteng Rt 01 Rw 02 Kel. Katulampa Kec. Bogor Timur Kota Bogor	16710	\N	3271020403070325	3271020909890014	\N	081281266286	asepsaepulloh.056@gmail.com	Jl. Parung Banteng Rt 01 Rw 02 Kel. Katulampa Kec. Bogor Timur Kota Bogor	Olahraga,Game	794235663404000	0953637364	BCA	2020-10-13 04:43:39	2020-10-13 04:44:34	75	1	\N
Sofyan Akbar Supni Komara	Tasikmalaya	16 September 1998	L	sunda	1	BK	Cibuluh Rt 001/008 Kel. Cibuluh Kec. Kota Bogor Utara, Kota Bogor	\N	\N	3271050203072525	3271051609980002	\N	0895603025221	sofyanakbar39@gmail.com	Cibuluh Rt 001/008 Kel. Cibuluh Kec. Kota Bogor Utara, Kota Bogor	Olah Raga	tidak punya	0953763637	BCA	2020-10-13 04:45:32	2020-10-13 04:45:32	76	1	\N
Suhermin Suryatin	Cirebon	15 Agustus 1978	P	jawa	3	C	Jl. Raya Pelepahan Indah Blok DC 13 / 19 Rulo Santa Monika RT 04 RW 02 Kel. Curug Sangereng Kec. Kelapa Dua	\N	\N	\N	3603285508780012	\N	082122707658	onoelborn97@yahoo.com	Apartemen Kalibata, Jakarta Selatan	Olah Raga	079511879426000	\N	BCA	2020-10-13 04:46:44	2020-10-13 04:46:44	77	1	\N
Budi Dwinanto	TB Tinggi	18 September 1982	L	jawa	1	K	Jl. Kesehatan Raya No. 3A RT 001 RW 006 Kel. Bintaro Kec. Pesanggrahan	\N	\N	\N	3174101809820004	\N	08159778976	budidwinanto@gmail.com	Jl. WR. Supratman Raya Griya Kamp. Utan Residenc Kav. A2 No.65, Tangsel	Olah Raga	590729489013000	\N	BCA	2020-10-13 04:48:07	2020-10-13 04:48:07	78	1	\N
Cinta Yosiana Dewi	Cianjur	06 Maret 1985	P	sunda	1	K	Kp. Cikeas Rt 02 Rw 10 Kel. Bojong Koneng Kec. Babakan Madang	16811	\N	3201052302160008	3273064603850010	\N	082227071157	cinta.mnc@gmail.com	Kp. Cikeas Rt 02 Rw 10 Kel. Bojong Koneng Kec. Babakan Madang	Membaca	340353143429000	\N	BCA	2020-10-13 04:49:01	2020-10-13 04:49:01	79	1	\N
Ir Zakaria Antomi	Air Molek	17 Mei 1967	L	melayu	1	K2	Perum Taman Sentosa B J6 No 12A Rt 15/06 Kel. Sukaresmi Kec. Cikarang Selatan Kab. Bekasi	\N	\N	\N	3216191705670004	\N	081398336057	zakaria.antomi@yahoo.co.id	Perum Taman Sentosa B J6 No 12A Rt 15/06 Kel. Sukaresmi Kec. Cikarang Selatan Kab. Bekasi	Olah Raga	688388073413000	5980107461	BCA	2020-10-13 06:19:21	2020-10-13 06:19:21	80	1	\N
Alfarisi	Bogor	25 April 1996	L	sunda	1	BK	Sindang Sari Rt 01 Rw 11 Kel. Tanah Baru Kec. Kota Bogor Utara Kab. Bogor	16154	\N	3271052706130013	3271052504960011	\N	08995912396	\N	Sindang Sari Rt 01 Rw 11 Kel. Tanah Baru Kec. Kota Bogor Utara Kab. Bogor	Menggambar	\N	8410478456	BCA	2020-10-13 06:21:44	2020-10-13 06:21:44	81	1	\N
Nadia Chairunnisa	Jakarta	18 Februari 1980	P	sunda	1	C3	Kp Kaum Rt 01 / Rw  Ii Kel. Mandalasari Kec. Cipatat Kab. Bandung Barat	40553	\N	3217072103120015	3217075802800003	0226900232	08122043612	chairunnisa.nadia@gmail.com	Perum Bumi Indraprasta Ii Jl. Drupada Raya No 1 Bogor Utara	Traveling	242469070421000	0953763491	BCA	2020-10-13 06:24:46	2020-10-13 06:24:46	82	1	\N
Muhamad Ramdani	Bogor	20 Desember 1997	L	sunda	1	BK	Kp. Cikeas RT 01 / 10 Ds Bojong Koneng, Kec. Babakan Madang Kab. Bogor	\N	\N	\N	3201052712970001	\N	085782150148/085691204680	ramdanimuhamad863@gmail.com	Kp. Cikeas RT 01 / 10 Ds Bojong Koneng, Kec. Babakan Madang Kab. Bogor	Olah Raga	\N	\N	BCA	2020-10-13 06:27:03	2020-10-13 06:27:03	83	1	\N
Muhamad Ibnu Maulana	Bogor	27 Mei 1997	L	sunda	1	K1	Jl. Pesantren No. 19 RT 02/06 Kel. Kedunghalang Kec. Bogor Utara Kota Bogor	\N	\N	\N	3271052705970012	\N	087870901989	mibnu2705@gmail.com	Jl. Pesantren No. 19 RT 02/06 Kel. Kedunghalang Kec. Bogor Utara Kota Bogor	Olah Raga	809638398404000	\N	BCA	2020-10-13 06:28:22	2020-10-13 06:28:22	84	1	\N
Ridwan Alamsyah	Jakarta	10 Maret 1980	L	minang	1	K2	Jl. Mutiara Baru No. 21 RT 03 RW 11 Kel. Bojong Gede Kec. Kedung Waringin Kab. Bogor	\N	\N	\N	3217061003800013	\N	082111033106	alamsyahr2005@gmail.com	Jl. Mutiara Baru No. 21 RT 03 RW 11 Kel. Bojong Gede Kec. Kedung Waringin Kab. Bogor	Olah Raga	365111194421000	\N	BCA	2020-10-13 06:30:29	2020-10-13 06:30:29	85	1	\N
Nova Catur Maulana	Jakarta	25 November 1985	L	jawa	1	K1	Jl. Duku III No. 59 A Blok V RT 02 RW 06 Kel. Baranangsiang Kec. Kota Bogor Timur Kota Bogor	\N	\N	\N	3271032511850001	\N	089661851917	novacaturmaulana@gmail.com	Jl. Duku III No. 59 A Blok V RT 02 RW 06 Kel. Baranangsiang Kec. Kota Bogor Timur Kota Bogor	Olah Raga	462661075404000	\N	BCA	2020-10-13 06:32:17	2020-10-13 06:32:17	86	1	\N
Novi Christiany	Bogor	16 November 1983	P	sunda	1	\N	Mutiara Bogor Raya F2/26 RT 01 RW 16 Kel. Katulampa Kec. Kota Bogor Timur	\N	\N	\N	3271025611820003	\N	08111611899	queen.novy83@gmail.com	Amarillo Village Blok Alton No. 11 Gading Serpong	Olah Raga	810321950404000	\N	BCA	2020-10-13 06:33:28	2020-10-13 06:33:28	87	1	\N
Joan Anthony Sulya	Bogor	24 Juli 1991	L	sunda	1	BK	Sirnagalih RT 01 RW 02 Kel. Harjasari Kec. Kota Bogor Selatan Kota Bogor	\N	\N	\N	3271012407910018	\N	081310479200	jojoj2256@gmail.com	Sirnagalih RT 01 RW 02 Kel. Harjasari Kec. Kota Bogor Selatan Kota Bogor	Olah Raga	641475413404000	\N	BCA	2020-10-13 06:34:23	2020-10-13 06:34:23	88	1	\N
Ulfa Novita Sari	Langsa	27 November 1986	P	batak	1	C	Kp. Sindangkarsa RT 05 RW 03 Kel. Sukamaju Baru Kec. Tapos Kota Depok	\N	\N	\N	3276026711860007	\N	081222395448	sari.siagian86@gmail.com	Kp. Sindangkarsa RT 05 RW 03 Kel. Sukamaju Baru Kec. Tapos Kota Depok	Olah Raga	716737994412000	\N	BCA	2020-10-13 06:35:17	2020-10-13 06:35:17	89	1	\N
Dedi Anggoro	Semarang	06 Januari 1988	L	jawa	1	K2	Basen KG.III/296 RT 15 RW 04 Kel. Purbayan Kec. Kotagede Kota Yogyakarta	\N	\N	\N	3374060601880002	\N	085866334673	dedi.anggoro.da@gmail.com	Jl. Puri Dinar Mas XIV no 7	Olah Raga	984082156517000	\N	BCA	2020-10-13 06:36:26	2020-10-13 06:36:26	90	1	\N
Rocky	Pontianak	29 Maret 1989	L	chinese	2	BK	Kp. Rempoa RT 01 RW 03 Kel. Rempoa Kec. Ciputat Timur Kota Tangerangan  Selatan	\N	\N	\N	3674052903890003	\N	087782112288	rocky_stefanus_ompi@yahoo.com	Jl. WR Supratman Komplek Harvest Residence Blok E No. 2 Kp. Utan Ciputat Timur	Olah Raga	709688568411000	\N	BCA	2020-10-13 06:37:23	2020-10-13 06:37:23	91	1	\N
Edwin Revano Andrian	Jayapura	12 November 1994	L	ambon	12	BK	Citra Pesona Buduran F-1/19 RT 37 RW 07 Kel. Sidokepung Kec. Buduran Kabupaten Sidoarjo	\N	\N	\N	9171011211940006	\N	082241303649	revanomustamu@gmail.com	Jl. Semolowaru No 14-43, Sukolilo, Surabaya	Olah Raga	861487734952000	\N	BCA	2020-10-13 06:38:19	2020-10-13 06:38:19	92	1	\N
Maesaroh	Bogor	15 Mei 1990	P	sunda	1	C2	Kp. Cimanggurang RT 01 RW 02 Kel. Cijayanti Kec. Babakan Madang Kab. Bogor	\N	\N	\N	3201265505900012	\N	089611668689	mesyazian@gmail.com	Kp. Cimanggurang RT 01 RW 02 Kel. Cijayanti Kec. Babakan Madang Kab. Bogor	Olah Raga	711460667403000	\N	BCA	2020-10-13 06:39:15	2020-10-13 06:39:15	93	1	\N
Andika Maulana Akbar	Bogor	20 Mei 2002	L	sunda	1	BK	Muara Beres RT 02 RW 04 Kel. Sukahati Kec. Cibinong Kab. Bogor	\N	\N	\N	3201012005020008	\N	0895352093939	maulanadika407@gmaial.com	Muara Beres RT 02 RW 04 Kel. Sukahati Kec. Cibinong Kab. Bogor	Olah Raga	\N	\N	\N	2020-10-13 06:41:37	2020-10-13 06:41:37	95	1	\N
Muhamad Satya	Bogor	10 Desember 1983	L	sunda	1	K2	Kp. Cikereteg Rt 01 / Rw 04 Kel. Ciderum Kec. Caringin, Kota Bogor	\N	\N	\N	3201271012830007	\N	085710651114	satyamuhamad@gmail.com	Kp. Cikereteg Rt 01 / Rw 04 Kel. Ciderum Kec. Caringin, Kota Bogor	Olah Raga	784572935434000	0953275527	BCA	2020-10-15 06:56:14	2020-10-15 06:56:14	96	1	\N
Prasetiawan G.S	Bogor	24 November 1986	L	sunda	1	K2	Bukit Mekar Wangi Blok C 13 NO 19 RT 04 RW 05 Kel. Mekarwangi Kec. Tanah Sareal Kota Bogor	16166	1606376359IMG_2585 copy.jpg	3271060406180007	3271022411860006	\N	081314162222, 081-1111-1186	hr.admin@olympic-development.com	Bukit Mekar Wangi Blok C 13 NO 19 RT 04 RW 05 Kel. Mekarwangi Kec. Tanah Sareal Kota Bogor	Traveling	892245259404000	0953757611	BCA	2020-10-13 02:49:27	2020-11-26 07:39:19	16	1	\N
Alian Ade	Kerinci	26 Februari 1979	L	melayu	1	BK	Griya Pratama Mas Blok D 1 No 7 RT 05 RW 07 Kel. Cikaragem Kec. Setu Kab. Bekasi	\N	\N	\N	3173082602790005	\N	081316305660	alanade.pratama@gmail.com	Jl. Mawar no. 19 RT 02 RW 06 Pondok Cina Depok	Olah Raga	584504278416000	8691484807	BCA	2020-11-26 07:56:27	2020-11-26 07:56:27	97	1	\N
Yannes Pasaribu	Jakarta	19 Januari 1969	L	\N	12	K3	Jl Cidodol Raya Komp Loka Permai No1-2 Rt 010/ 006 Kel Grogol Selatan Kec Kebayoran Lama Kota Jakarta Selatan	\N	1606378940_MG_1088 copy.jpg	3174051602100033	3171041901690005	\N	081399091172	\N	Jl Cidodol Raya Komp Loka Permai No1-2 Rt 010/ 006 Kel Grogol Selatan Kec Kebayoran Lama Kota Jakarta Selatan	\N	\N	6770052279	BCA	2020-10-13 02:37:33	2020-11-26 08:22:20	11	1	\N
Burhannudin	Bogor	06 Maret 1995	L	sunda	1	BK	Sampora RT 01 RW 01 Nanggewer Mekar Kel. Cibinong Kab Bogor	\N	\N	\N	3201010603951002	\N	085694010656	Burhannudinmbuyy@gmail.com	Sampora RT 01 RW 01 Nanggewer Mekar Kel. Cibinong Kab Bogor	Olah Raga	\N	8410486050	BCA	2020-10-13 03:39:56	2021-01-06 02:41:38	38	1	\N
Niko Arsi Harkenijandra	Jakarta	29 Oktober 1984	L	jawa	1	BK	Kav. DKI Blok 40/16 RT 02 RW 10 Kel Meruya Utara Kec. Kembangan Jakarta Barat	11620	\N	3173082604180001	3173082910840008	\N	08787693747	niko_arsi@yahoo.com, nikoarsi16@gmail.com	Jl. Penyelesaian Tomang II .Kav. DKI Blok 40/16 RT 02 RW 10 Kel Meruya Utara Kec. Kembangan Jakarta Barat	Basket	674328836086000	3721125333	BCA	2020-10-13 03:24:11	2021-04-05 04:47:24	31	1	1
Novan Abdilah Agilyansyah	Bogor	06 November 1992	L	sunda	1	K	Kp. Bongas 3 RT 02 RW 09 Kel. Kalongliud Kec. Nanggung Kab. Bogor	16650	1617607035ocbd2.jpg	\N	3672050611920002	\N	081288650512	novanokkey@gmail.com	Kp. Bongas 3 RT 02 RW 09 Kel. Kalongliud Kec. Nanggung Kab. Bogor	makan	732223235434000	\N	BCA	2020-10-13 06:40:39	2021-04-05 07:17:15	94	1	\N
\.


--
-- TOC entry 3104 (class 0 OID 53724)
-- Dependencies: 233
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
-- TOC entry 3118 (class 0 OID 53819)
-- Dependencies: 247
-- Data for Name: tabel_lembur; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_lembur (id_lembur, no_dok, created_at, updated_at, hari, tgl_pengajuan, tgl_lembur, kegiatan, atasan1, atasan2, catatan, jam_mulai, jam_akhir, total_jam, um, id_karyawan_personal, status_pengajuan, alasan_tolak) FROM stdin;
7	\N	2021-04-07 10:41:35	2021-04-07 10:48:10	Sabtu	2021-04-07	2021-04-10	upgrade server	31	10	untuk pemasangan diusahakan harus selesai segera	18:00:00	22:30:00	16200	\N	94	1	ok
5	\N	2021-04-07 10:40:33	2021-04-07 10:48:59	Senin	2021-04-07	2021-04-05	pasang kabel	31	10	ok lanjutkan sebaik baiknya	18:00:00	20:00:00	7200	\N	94	1	ok
6	\N	2021-04-07 10:41:22	2021-04-07 11:06:31	Kamis	2021-04-07	2021-04-08	upgrade server impro	31	10	untuk pemasangan diusahakan harus selesai segera	17:00:00	21:00:00	14400	\N	94	1	ok
8	\N	2021-04-07 11:07:18	2021-04-07 11:10:26	Jumat	2021-04-07	2021-04-30	pasang kabel	31	10	untuk pemasangan diusahakan harus selesai segera	18:00:00	23:00:00	18000	\N	94	1	ok
9	\N	2021-04-08 15:20:44	2021-04-08 15:22:29	Kamis	2021-04-08	2021-04-08	pasang kabel	31	10	jangan lembur dulu	18:00:00	22:00:00	14400	\N	94	3	ganti hari
10	\N	2021-04-08 15:23:50	2021-04-08 15:26:33	Kamis	2021-04-08	2021-04-08	pasang kabel	31	10	tolong dimaksimalkan	19:00:00	23:00:00	14400	\N	94	1	ok
\.


--
-- TOC entry 3078 (class 0 OID 53204)
-- Dependencies: 207
-- Data for Name: tabel_level; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_level (id_level, level, created_at, updated_at) FROM stdin;
1	DIR	\N	\N
3	MNG	2020-10-06 06:28:37	2020-10-06 06:28:37
4	SPV	2020-10-06 06:28:44	2020-10-06 06:28:44
6	STF	2020-10-06 06:29:13	2020-10-06 06:29:13
7	SENIOR STAFF	2020-10-06 06:29:19	2020-10-13 02:05:55
10	SPV	2020-10-13 02:06:03	2020-10-13 02:06:03
11	STAFF	2020-10-13 02:06:10	2020-10-13 02:06:10
\.


--
-- TOC entry 3125 (class 0 OID 53931)
-- Dependencies: 254
-- Data for Name: tabel_log_absen; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_log_absen (created_at, updated_at, "PIN", id_karyawan_personal, checktime, checktype, alatabsen, row_id) FROM stdin;
2021-03-29 04:50:34	2021-03-29 04:50:34	397	94	2021-03-29 11:50:28	I	web	9
2021-03-29 04:52:23	2021-03-29 04:52:23	397	94	2021-03-29 11:52:15	I	web	10
2021-03-29 04:53:48	2021-03-29 04:53:48	397	94	2021-03-29 11:53:41	I	web	11
2021-03-29 05:49:40	2021-03-29 05:49:40	397	94	2021-03-29 12:49:34	I	web	12
2021-03-29 06:00:20	2021-03-29 06:00:20	397	94	2021-03-29 13:00:15	I	web	13
2021-03-29 06:20:36	2021-03-29 06:20:36	397	94	2021-03-29 13:20:31	I	web	14
2021-03-29 06:21:27	2021-03-29 06:21:27	397	94	2021-03-29 13:21:23	I	web	15
2021-03-29 06:26:28	2021-03-29 06:26:28	397	94	2021-03-29 13:26:11	I	web	16
2021-03-29 06:27:05	2021-03-29 06:27:05	397	94	2021-03-29 13:26:28	O	web	17
2021-03-29 06:29:22	2021-03-29 06:29:22	397	94	2021-03-29 13:29:14	I	web	18
2021-03-29 07:28:56	2021-03-29 07:28:56	397	94	2021-03-29 14:28:50	I	web	19
2021-03-29 07:33:00	2021-03-29 07:33:00	397	94	2021-03-29 14:32:56	I	web	20
2021-03-29 07:34:23	2021-03-29 07:34:23	397	94	2021-03-29 14:34:19	I	web	21
2021-03-29 07:37:09	2021-03-29 07:37:09	397	94	2021-03-29 14:37:03	I	web	22
2021-03-29 07:40:44	2021-03-29 07:40:44	397	94	2021-03-29 14:40:39	I	web	23
2021-03-29 07:41:32	2021-03-29 07:41:32	397	94	2021-03-29 14:41:24	I	web	24
2021-03-29 07:45:16	2021-03-29 07:45:16	397	94	2021-03-29 14:45:11	I	web	25
2021-03-29 08:19:13	2021-03-29 08:19:13	397	94	2021-03-29 15:18:52	I	web	26
2021-03-29 08:49:16	2021-03-29 08:49:16	397	94	2021-03-29 15:48:49	I	web	27
2021-03-29 08:50:27	2021-03-29 08:50:27	397	94	2021-03-29 15:50:13	I	web	28
2021-03-29 08:57:25	2021-03-29 08:57:25	397	94	2021-03-29 15:57:15	I	web	29
2021-03-29 09:01:57	2021-03-29 09:01:57	397	94	2021-03-29 16:01:42	I	web	30
2021-03-29 09:06:31	2021-03-29 09:06:31	397	94	2021-03-29 16:06:15	I	web	31
2021-03-29 09:11:29	2021-03-29 09:11:29	397	94	2021-03-29 16:11:20	I	web	32
2021-03-29 09:11:57	2021-03-29 09:11:57	397	94	2021-03-29 16:11:49	I	web	33
2021-03-29 09:30:55	2021-03-29 09:30:55	397	94	2021-03-29 16:30:46	I	web	34
2021-03-29 09:31:54	2021-03-29 09:31:54	397	94	2021-03-29 16:31:46	I	web	35
2021-03-31 08:55:45	2021-03-31 08:55:45	397	94	2021-03-31 15:55:32	I	web	36
2021-04-01 09:12:24	2021-04-01 09:12:24	397	94	2021-04-01 16:12:18	I	web	37
2021-04-01 09:17:34	2021-04-01 09:17:34	397	94	2021-04-01 16:16:38	I	web	38
2021-04-01 09:19:00	2021-04-01 09:19:00	397	94	2021-04-01 16:17:34	O	web	39
2021-04-05 06:13:56	2021-04-05 06:13:56	397	94	2021-04-05 13:13:40	I	web	40
2021-04-05 06:18:01	2021-04-05 06:18:01	397	94	2021-04-05 13:17:55	I	web	41
\.


--
-- TOC entry 3116 (class 0 OID 53808)
-- Dependencies: 245
-- Data for Name: tabel_perjalanan_detail; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_perjalanan_detail (id_penugasan_karyawan, id_perjalan, created_at, updated_at, npk, nama_karyawan, jabatan, departemen) FROM stdin;
\.


--
-- TOC entry 3114 (class 0 OID 53783)
-- Dependencies: 243
-- Data for Name: tabel_perjalanan_dinas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_perjalanan_dinas (id_penugasan, created_at, updated_at, tgl_mulai, tgl_akhir, tujuan, person_dituju, uraian_tugas, transportasi_perhari, transportasi_jumlah, transportasi_keterangan, status_pengajuan, akomodasi_perhari, akomodasi_jumlah, akomodasi_keterangan, tm_perhari, tm_jumlah, tm_keterangan, lain_perhari, lain_jumlah, lain_keterangan, tgl_pengajuan, pemohon, ditugaskan, disetujui, no_formulir) FROM stdin;
\.


--
-- TOC entry 3110 (class 0 OID 53764)
-- Dependencies: 239
-- Data for Name: tabel_struktur_jabatan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tabel_struktur_jabatan (id_struktur, created_at, updated_at, idjabatan, idlevel, idjabatan_atasan, iddepartemen, idjamkerja) FROM stdin;
4	2021-03-08 07:49:43	2021-03-08 07:49:43	40	\N	\N	\N	\N
7	2021-03-08 08:00:32	2021-03-08 08:00:32	56	3	8	10	\N
8	2021-03-08 08:06:01	2021-03-08 08:06:01	57	3	56	10	\N
9	2021-03-08 08:06:35	2021-03-08 08:06:35	58	6	57	10	\N
10	2021-03-08 08:07:20	2021-03-08 08:07:20	51	4	57	10	\N
11	2021-03-08 08:07:56	2021-03-08 08:07:56	23	6	51	10	\N
12	2021-03-08 08:08:29	2021-03-08 08:08:29	39	4	56	10	\N
13	2021-03-08 08:09:07	2021-03-08 08:09:07	13	6	39	10	\N
14	2021-03-08 08:09:27	2021-03-08 08:09:27	7	6	39	10	\N
15	2021-03-08 08:10:30	2021-03-08 08:10:30	16	1	40	12	\N
16	2021-03-08 08:11:16	2021-03-08 08:11:16	47	6	16	12	\N
17	2021-03-08 08:11:57	2021-03-08 08:11:57	17	3	16	12	\N
18	2021-03-08 08:12:33	2021-03-08 08:14:42	3	6	62	12	\N
19	2021-03-08 08:14:05	2021-03-08 08:15:15	62	4	17	12	\N
20	2021-03-08 08:15:58	2021-03-08 08:15:58	53	6	17	12	\N
21	2021-03-08 08:16:40	2021-03-08 08:16:40	60	3	16	12	\N
22	2021-03-08 08:17:16	2021-03-08 08:17:16	61	6	60	12	\N
23	2021-03-08 08:17:56	2021-03-08 08:17:56	52	6	60	12	\N
24	2021-03-08 08:18:24	2021-03-08 08:18:24	33	1	40	7	\N
25	2021-03-08 08:19:31	2021-03-08 08:19:31	31	3	33	7	\N
26	2021-03-08 08:20:18	2021-03-08 08:20:18	15	6	31	7	\N
27	2021-03-08 08:20:51	2021-03-08 08:20:51	30	6	31	7	\N
28	2021-03-08 08:21:23	2021-03-08 08:21:23	11	4	33	7	\N
29	2021-03-08 08:21:44	2021-03-08 08:21:44	24	6	11	7	\N
30	2021-03-08 08:22:28	2021-03-08 08:22:28	32	3	33	7	\N
31	2021-03-08 08:22:45	2021-03-08 08:22:45	49	6	32	7	\N
32	2021-03-08 08:23:21	2021-03-08 08:23:21	19	4	33	7	\N
33	2021-03-08 08:23:56	2021-03-08 08:23:56	18	6	19	7	\N
34	2021-03-08 08:24:39	2021-03-08 08:24:39	14	6	19	7	\N
35	2021-03-08 08:25:28	2021-03-08 08:25:28	29	6	19	7	\N
36	2021-03-08 08:25:45	2021-03-08 08:25:45	28	6	19	7	\N
37	2021-03-08 08:26:23	2021-03-08 08:26:23	43	1	40	9	\N
38	2021-03-08 08:27:38	2021-03-08 08:27:38	63	6	43	9	\N
39	2021-03-08 08:28:10	2021-03-08 08:28:10	20	3	43	9	\N
40	2021-03-08 08:28:51	2021-03-08 08:28:51	22	4	20	9	\N
41	2021-03-08 08:29:08	2021-03-08 08:29:08	6	6	22	9	\N
42	2021-03-08 08:29:50	2021-03-08 08:29:50	64	3	20	9	\N
43	2021-03-08 08:30:47	2021-03-08 08:30:47	45	3	64	9	\N
44	2021-03-08 08:31:21	2021-03-08 08:31:21	35	3	20	9	\N
45	2021-03-08 08:31:48	2021-03-08 08:31:48	21	4	35	9	\N
46	2021-03-08 08:32:06	2021-03-08 08:32:06	34	6	21	9	\N
47	2021-03-08 08:32:39	2021-03-08 08:32:39	12	4	35	9	\N
48	2021-03-08 08:33:00	2021-03-08 08:33:00	10	6	12	9	\N
49	2021-03-08 08:33:32	2021-03-08 08:33:32	26	1	40	13	\N
50	2021-03-08 08:34:03	2021-03-08 08:34:03	27	6	26	13	\N
51	2021-03-08 08:34:20	2021-03-08 08:34:20	25	4	26	13	\N
52	2021-03-08 08:36:14	2021-03-08 08:36:14	38	6	41	8	\N
53	2021-03-08 08:36:32	2021-03-08 08:36:32	4	6	41	8	\N
54	2021-03-08 08:37:24	2021-03-08 08:37:24	50	6	41	8	\N
55	2021-03-08 08:38:29	2021-03-08 08:38:29	36	4	41	8	\N
5	2021-03-08 07:51:53	2021-03-12 04:31:01	8	1	40	10	1
6	2021-03-08 07:59:46	2021-03-12 04:31:22	55	6	8	10	1
\.


--
-- TOC entry 3097 (class 0 OID 53599)
-- Dependencies: 226
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at, level, status_user, id_karyawan_personal, imei, macaddr) FROM stdin;
1	hrd	hrd@gmail.com	\N	$2y$10$blVcrIh2xhdfPr1uEkzNpObKXPEL1IrxtdHg0E8x403xDuMuyN.pu	j3JZyjWL4hZjn4fXqhx2j72FwrWFxhImRLpiKlv6U0YZhadjp7w7OmxtRt0J	2020-10-08 08:38:19	2020-10-08 08:38:19	hrd	1	\N	\N	\N
6	NOVAN ABDILAH A	novan.abdilah@ocbd.co.id	\N	$2y$10$blVcrIh2xhdfPr1uEkzNpObKXPEL1IrxtdHg0E8x403xDuMuyN.pu	Qlt0NGc9H8IIoYoryyct1dBikT9G7e6zr7bFHsu0bCmXwU2n51dpv57jLtZk	2021-03-03 08:31:12	2021-03-03 08:44:30	karyawan	1	94	\N	\N
10	Niko Arsi Harkenijandra	niko@ocbd.co.id	\N	$2y$10$m2VlqRlFtXp5mQa8Wyn3yuNsztt.HhX0zea5kewMtC2snxV8rspaO	mowBhIa44Y1iXZXnhSkwFxajnfEgSL37Ek6rLhFzs2hWF96m7tSbXEyR0lHv	2021-04-05 04:47:23	2021-04-05 04:47:23	karyawan	1	31	\N	\N
4	admin	admin@gmail.com	\N	$2y$10$blVcrIh2xhdfPr1uEkzNpObKXPEL1IrxtdHg0E8x403xDuMuyN.pu	YJgF0J2WmwlDXfTHTaor9BGZOZada8wAXnA9nBFgKjcBirKbkYsfJeCO3NIW	\N	\N	admin	1	\N	\N	\N
\.


--
-- TOC entry 3159 (class 0 OID 0)
-- Dependencies: 222
-- Name: karyawan_data_id_karyawan_personal_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.karyawan_data_id_karyawan_personal_seq', 1, true);


--
-- TOC entry 3160 (class 0 OID 0)
-- Dependencies: 212
-- Name: karyawan_data_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.karyawan_data_id_seq', 24, true);


--
-- TOC entry 3161 (class 0 OID 0)
-- Dependencies: 214
-- Name: karyawan_file_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.karyawan_file_id_seq', 17, true);


--
-- TOC entry 3162 (class 0 OID 0)
-- Dependencies: 216
-- Name: karyawan_keluarga_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.karyawan_keluarga_id_seq', 6, true);


--
-- TOC entry 3163 (class 0 OID 0)
-- Dependencies: 218
-- Name: karyawan_pekerjaan_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.karyawan_pekerjaan_id_seq', 3, true);


--
-- TOC entry 3164 (class 0 OID 0)
-- Dependencies: 220
-- Name: karyawan_pendidikan_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.karyawan_pendidikan_id_seq', 6, true);


--
-- TOC entry 3165 (class 0 OID 0)
-- Dependencies: 223
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 2, true);


--
-- TOC entry 3166 (class 0 OID 0)
-- Dependencies: 236
-- Name: tabel_absen_harian_id_kalender_kerja_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_absen_harian_id_kalender_kerja_seq', 82, true);


--
-- TOC entry 3167 (class 0 OID 0)
-- Dependencies: 202
-- Name: tabel_agama_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_agama_id_seq', 12, true);


--
-- TOC entry 3168 (class 0 OID 0)
-- Dependencies: 240
-- Name: tabel_cuti_id_struktur_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_cuti_id_struktur_seq', 15, true);


--
-- TOC entry 3169 (class 0 OID 0)
-- Dependencies: 248
-- Name: tabel_datang_terlambat_id_detail_lembur_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_datang_terlambat_id_detail_lembur_seq', 3, true);


--
-- TOC entry 3170 (class 0 OID 0)
-- Dependencies: 208
-- Name: tabel_departemen_id_level_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_departemen_id_level_seq', 6, true);


--
-- TOC entry 3171 (class 0 OID 0)
-- Dependencies: 250
-- Name: tabel_ganti_hari_kerja_id_terlambat_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_ganti_hari_kerja_id_terlambat_seq', 4, true);


--
-- TOC entry 3172 (class 0 OID 0)
-- Dependencies: 228
-- Name: tabel_golongan_id_jabatan_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_golongan_id_jabatan_seq', 4, true);


--
-- TOC entry 3173 (class 0 OID 0)
-- Dependencies: 204
-- Name: tabel_jabatan_id_agama_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_jabatan_id_agama_seq', 14, true);


--
-- TOC entry 3174 (class 0 OID 0)
-- Dependencies: 230
-- Name: tabel_jam_kerja_id_agama_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_jam_kerja_id_agama_seq', 7, true);


--
-- TOC entry 3175 (class 0 OID 0)
-- Dependencies: 252
-- Name: tabel_jatah_cuti_id_cuti_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_jatah_cuti_id_cuti_seq', 88, true);


--
-- TOC entry 3176 (class 0 OID 0)
-- Dependencies: 234
-- Name: tabel_kalender_kerja_id_agama_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_kalender_kerja_id_agama_seq', 3, true);


--
-- TOC entry 3177 (class 0 OID 0)
-- Dependencies: 210
-- Name: tabel_karyawan_personal_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_karyawan_personal_id_seq', 19, true);


--
-- TOC entry 3178 (class 0 OID 0)
-- Dependencies: 232
-- Name: tabel_kategori_absen_id_agama_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_kategori_absen_id_agama_seq', 11, true);


--
-- TOC entry 3179 (class 0 OID 0)
-- Dependencies: 246
-- Name: tabel_lembur_id_jabatan_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_lembur_id_jabatan_seq', 10, true);


--
-- TOC entry 3180 (class 0 OID 0)
-- Dependencies: 206
-- Name: tabel_level_id_jabatan_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_level_id_jabatan_seq', 10, true);


--
-- TOC entry 3181 (class 0 OID 0)
-- Dependencies: 255
-- Name: tabel_log_absen_row_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_log_absen_row_id_seq', 41, true);


--
-- TOC entry 3182 (class 0 OID 0)
-- Dependencies: 244
-- Name: tabel_penugasan_karyawan_id_level_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_penugasan_karyawan_id_level_seq', 1, false);


--
-- TOC entry 3183 (class 0 OID 0)
-- Dependencies: 242
-- Name: tabel_perjalanan_dinas_id_cuti_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_perjalanan_dinas_id_cuti_seq', 1, false);


--
-- TOC entry 3184 (class 0 OID 0)
-- Dependencies: 238
-- Name: tabel_struktur_jabatan_id_jabatan_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tabel_struktur_jabatan_id_jabatan_seq', 55, true);


--
-- TOC entry 3185 (class 0 OID 0)
-- Dependencies: 225
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 10, true);


--
-- TOC entry 2898 (class 2606 OID 53262)
-- Name: tabel_karyawan_data karyawan_data_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_karyawan_data
    ADD CONSTRAINT karyawan_data_pkey PRIMARY KEY (id_karyawan);


--
-- TOC entry 2900 (class 2606 OID 53273)
-- Name: tabel_karyawan_file karyawan_file_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_karyawan_file
    ADD CONSTRAINT karyawan_file_pkey PRIMARY KEY (id_karyawanfile);


--
-- TOC entry 2902 (class 2606 OID 53284)
-- Name: tabel_karyawan_keluarga karyawan_keluarga_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_karyawan_keluarga
    ADD CONSTRAINT karyawan_keluarga_pkey PRIMARY KEY (id_karyawankeluarga);


--
-- TOC entry 2904 (class 2606 OID 53295)
-- Name: tabel_karyawan_pekerjaan karyawan_pekerjaan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_karyawan_pekerjaan
    ADD CONSTRAINT karyawan_pekerjaan_pkey PRIMARY KEY (id_karyawanpekerjaan);


--
-- TOC entry 2906 (class 2606 OID 53306)
-- Name: tabel_karyawan_pendidikan karyawan_pendidikan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_karyawan_pendidikan
    ADD CONSTRAINT karyawan_pendidikan_pkey PRIMARY KEY (id_karyawanpendidikan);


--
-- TOC entry 2908 (class 2606 OID 53596)
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- TOC entry 2923 (class 2606 OID 53745)
-- Name: tabel_absen_harian tabel_absen_harian_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_absen_harian
    ADD CONSTRAINT tabel_absen_harian_pkey PRIMARY KEY (id_absen);


--
-- TOC entry 2888 (class 2606 OID 53193)
-- Name: tabel_agama tabel_agama_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_agama
    ADD CONSTRAINT tabel_agama_pkey PRIMARY KEY (id_agama);


--
-- TOC entry 2927 (class 2606 OID 53777)
-- Name: tabel_cuti tabel_cuti_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_cuti
    ADD CONSTRAINT tabel_cuti_pkey PRIMARY KEY (id_cuti);


--
-- TOC entry 2935 (class 2606 OID 53857)
-- Name: tabel_datang_terlambat tabel_datang_terlambat_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_datang_terlambat
    ADD CONSTRAINT tabel_datang_terlambat_pkey PRIMARY KEY (id_terlambat);


--
-- TOC entry 2894 (class 2606 OID 53217)
-- Name: tabel_departemen tabel_departemen_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_departemen
    ADD CONSTRAINT tabel_departemen_pkey PRIMARY KEY (id_departemen);


--
-- TOC entry 2937 (class 2606 OID 53868)
-- Name: tabel_ganti_hari_kerja tabel_ganti_hari_kerja_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_ganti_hari_kerja
    ADD CONSTRAINT tabel_ganti_hari_kerja_pkey PRIMARY KEY (id_ganti_hari);


--
-- TOC entry 2915 (class 2606 OID 53624)
-- Name: tabel_golongan tabel_golongan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_golongan
    ADD CONSTRAINT tabel_golongan_pkey PRIMARY KEY (id_golongan);


--
-- TOC entry 2890 (class 2606 OID 53201)
-- Name: tabel_jabatan tabel_jabatan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_jabatan
    ADD CONSTRAINT tabel_jabatan_pkey PRIMARY KEY (id_jabatan);


--
-- TOC entry 2917 (class 2606 OID 53721)
-- Name: tabel_jam_kerja tabel_jam_kerja_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_jam_kerja
    ADD CONSTRAINT tabel_jam_kerja_pkey PRIMARY KEY (id_jamkerja);


--
-- TOC entry 2939 (class 2606 OID 53886)
-- Name: tabel_jatah_cuti tabel_jatah_cuti_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_jatah_cuti
    ADD CONSTRAINT tabel_jatah_cuti_pkey PRIMARY KEY (id_jatah_cuti);


--
-- TOC entry 2921 (class 2606 OID 53737)
-- Name: tabel_kalender_kerja tabel_kalender_kerja_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_kalender_kerja
    ADD CONSTRAINT tabel_kalender_kerja_pkey PRIMARY KEY (id_kalender_kerja);


--
-- TOC entry 2896 (class 2606 OID 53228)
-- Name: tabel_karyawan_personal tabel_karyawan_personal_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_karyawan_personal
    ADD CONSTRAINT tabel_karyawan_personal_pkey PRIMARY KEY (id_karyawan_personal);


--
-- TOC entry 2919 (class 2606 OID 53729)
-- Name: tabel_kategori_absen tabel_kategori_absen_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_kategori_absen
    ADD CONSTRAINT tabel_kategori_absen_pkey PRIMARY KEY (id_kategori_absen);


--
-- TOC entry 2933 (class 2606 OID 53824)
-- Name: tabel_lembur tabel_lembur_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_lembur
    ADD CONSTRAINT tabel_lembur_pkey PRIMARY KEY (id_lembur);


--
-- TOC entry 2892 (class 2606 OID 53209)
-- Name: tabel_level tabel_level_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_level
    ADD CONSTRAINT tabel_level_pkey PRIMARY KEY (id_level);


--
-- TOC entry 2941 (class 2606 OID 53977)
-- Name: tabel_log_absen tabel_log_absen_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_log_absen
    ADD CONSTRAINT tabel_log_absen_pkey PRIMARY KEY (row_id);


--
-- TOC entry 2931 (class 2606 OID 53813)
-- Name: tabel_perjalanan_detail tabel_penugasan_karyawan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_perjalanan_detail
    ADD CONSTRAINT tabel_penugasan_karyawan_pkey PRIMARY KEY (id_penugasan_karyawan);


--
-- TOC entry 2929 (class 2606 OID 53791)
-- Name: tabel_perjalanan_dinas tabel_perjalanan_dinas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_perjalanan_dinas
    ADD CONSTRAINT tabel_perjalanan_dinas_pkey PRIMARY KEY (id_penugasan);


--
-- TOC entry 2925 (class 2606 OID 53769)
-- Name: tabel_struktur_jabatan tabel_struktur_jabatan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_struktur_jabatan
    ADD CONSTRAINT tabel_struktur_jabatan_pkey PRIMARY KEY (id_struktur);


--
-- TOC entry 2910 (class 2606 OID 53609)
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- TOC entry 2912 (class 2606 OID 53607)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 2913 (class 1259 OID 53616)
-- Name: password_resets_email_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX password_resets_email_index ON public.password_resets USING btree (email);


--
-- TOC entry 2942 (class 2606 OID 53890)
-- Name: tabel_struktur_jabatan tabel_struktur_jabatan_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_struktur_jabatan
    ADD CONSTRAINT tabel_struktur_jabatan_fk FOREIGN KEY (iddepartemen) REFERENCES public.tabel_departemen(id_departemen);


--
-- TOC entry 2943 (class 2606 OID 53895)
-- Name: tabel_struktur_jabatan tabel_struktur_jabatan_fk1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_struktur_jabatan
    ADD CONSTRAINT tabel_struktur_jabatan_fk1 FOREIGN KEY (idjabatan) REFERENCES public.tabel_jabatan(id_jabatan);


--
-- TOC entry 2944 (class 2606 OID 53900)
-- Name: tabel_struktur_jabatan tabel_struktur_jabatan_fk2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_struktur_jabatan
    ADD CONSTRAINT tabel_struktur_jabatan_fk2 FOREIGN KEY (idjabatan_atasan) REFERENCES public.tabel_jabatan(id_jabatan);


--
-- TOC entry 2945 (class 2606 OID 53905)
-- Name: tabel_struktur_jabatan tabel_struktur_jabatan_fk3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_struktur_jabatan
    ADD CONSTRAINT tabel_struktur_jabatan_fk3 FOREIGN KEY (idlevel) REFERENCES public.tabel_level(id_level);


--
-- TOC entry 2946 (class 2606 OID 53924)
-- Name: tabel_struktur_jabatan tabel_struktur_jabatan_fk4; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tabel_struktur_jabatan
    ADD CONSTRAINT tabel_struktur_jabatan_fk4 FOREIGN KEY (idjamkerja) REFERENCES public.tabel_jam_kerja(id_jamkerja);


-- Completed on 2021-04-15 14:21:48

--
-- PostgreSQL database dump complete
--

