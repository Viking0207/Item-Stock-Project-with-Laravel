--
-- PostgreSQL database dump
--

\restrict HtiaVSZFDcZ03Ncb9GvjXQHheztb64bIzgSWEisVRx4Rp7vzGLpnji8jVG4gpR8

-- Dumped from database version 17.6
-- Dumped by pg_dump version 18.1

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: public; Type: SCHEMA; Schema: -; Owner: -
--

CREATE SCHEMA public;


--
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: -
--

COMMENT ON SCHEMA public IS 'standard public schema';


--
-- Name: update_timestamp(); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION public.update_timestamp() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = NOW();
    RETURN NEW;
END;
$$;


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: batch_tb_alat_tulis; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.batch_tb_alat_tulis (
    id bigint NOT NULL,
    barang_id bigint NOT NULL,
    plu_barang character varying(20) NOT NULL,
    expired_date date,
    price integer NOT NULL,
    quantity integer DEFAULT 0 NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: batch_tb_alat_tulis_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.batch_tb_alat_tulis_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: batch_tb_alat_tulis_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.batch_tb_alat_tulis_id_seq OWNED BY public.batch_tb_alat_tulis.id;


--
-- Name: batch_tb_bahan_masakan; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.batch_tb_bahan_masakan (
    id bigint NOT NULL,
    barang_id bigint NOT NULL,
    plu_barang character varying(20) NOT NULL,
    expired_date date,
    price integer NOT NULL,
    quantity integer DEFAULT 0 NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: batch_tb_bahan_masakan_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.batch_tb_bahan_masakan_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: batch_tb_bahan_masakan_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.batch_tb_bahan_masakan_id_seq OWNED BY public.batch_tb_bahan_masakan.id;


--
-- Name: batch_tb_kosmetik; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.batch_tb_kosmetik (
    id bigint NOT NULL,
    barang_id bigint NOT NULL,
    plu_barang character varying(20) NOT NULL,
    expired_date date,
    price integer NOT NULL,
    quantity integer DEFAULT 0 NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: batch_tb_kosmetik_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.batch_tb_kosmetik_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: batch_tb_kosmetik_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.batch_tb_kosmetik_id_seq OWNED BY public.batch_tb_kosmetik.id;


--
-- Name: batch_tb_makanan; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.batch_tb_makanan (
    id bigint NOT NULL,
    barang_id bigint NOT NULL,
    plu_barang character varying(20) NOT NULL,
    expired_date date,
    price integer NOT NULL,
    quantity integer DEFAULT 0 NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: batch_tb_makanan_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.batch_tb_makanan_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: batch_tb_makanan_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.batch_tb_makanan_id_seq OWNED BY public.batch_tb_makanan.id;


--
-- Name: batch_tb_minuman; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.batch_tb_minuman (
    id bigint NOT NULL,
    barang_id bigint NOT NULL,
    plu_barang character varying(20) NOT NULL,
    expired_date date,
    price integer NOT NULL,
    quantity integer DEFAULT 0 NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: batch_tb_minuman_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.batch_tb_minuman_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: batch_tb_minuman_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.batch_tb_minuman_id_seq OWNED BY public.batch_tb_minuman.id;


--
-- Name: batch_tb_obat; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.batch_tb_obat (
    id bigint NOT NULL,
    barang_id bigint NOT NULL,
    plu_barang character varying(20) NOT NULL,
    expired_date date,
    price integer NOT NULL,
    quantity integer DEFAULT 0 NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: batch_tb_obat_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.batch_tb_obat_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: batch_tb_obat_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.batch_tb_obat_id_seq OWNED BY public.batch_tb_obat.id;


--
-- Name: batch_tb_pembersih; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.batch_tb_pembersih (
    id bigint NOT NULL,
    barang_id bigint NOT NULL,
    plu_barang character varying(20) NOT NULL,
    expired_date date,
    price integer NOT NULL,
    quantity integer DEFAULT 0 NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: batch_tb_pembersih_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.batch_tb_pembersih_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: batch_tb_pembersih_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.batch_tb_pembersih_id_seq OWNED BY public.batch_tb_pembersih.id;


--
-- Name: batch_tb_perabotan_rumah; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.batch_tb_perabotan_rumah (
    id bigint NOT NULL,
    barang_id bigint NOT NULL,
    plu_barang character varying(20) NOT NULL,
    expired_date date,
    price integer NOT NULL,
    quantity integer DEFAULT 0 NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: batch_tb_perabotan_rumah_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.batch_tb_perabotan_rumah_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: batch_tb_perabotan_rumah_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.batch_tb_perabotan_rumah_id_seq OWNED BY public.batch_tb_perabotan_rumah.id;


--
-- Name: cache; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


--
-- Name: jobs; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


--
-- Name: pengguna; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.pengguna (
    id bigint NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    role character varying(20) NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    CONSTRAINT pengguna_role_check CHECK (((role)::text = ANY ((ARRAY['karyawan'::character varying, 'kasir'::character varying])::text[])))
);


--
-- Name: pengguna_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.pengguna_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: pengguna_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.pengguna_id_seq OWNED BY public.pengguna.id;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


--
-- Name: tb_alat_tulis; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.tb_alat_tulis (
    id bigint NOT NULL,
    plu_barang character varying(20) NOT NULL,
    nama_barang character varying(100) NOT NULL,
    total_quantity integer DEFAULT 0 NOT NULL,
    harga_terakhir integer DEFAULT 0 NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: tb_alat_tulis_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.tb_alat_tulis_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tb_alat_tulis_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.tb_alat_tulis_id_seq OWNED BY public.tb_alat_tulis.id;


--
-- Name: tb_bahan_masakan; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.tb_bahan_masakan (
    id bigint NOT NULL,
    plu_barang character varying(20) NOT NULL,
    nama_barang character varying(100) NOT NULL,
    total_quantity integer DEFAULT 0 NOT NULL,
    harga_terakhir integer DEFAULT 0 NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: tb_bahan_masakan_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.tb_bahan_masakan_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tb_bahan_masakan_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.tb_bahan_masakan_id_seq OWNED BY public.tb_bahan_masakan.id;


--
-- Name: tb_kategori; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.tb_kategori (
    id bigint NOT NULL,
    nama_kategori character varying(100) NOT NULL,
    kode_awal character varying(5) NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: tb_kategori_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.tb_kategori_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tb_kategori_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.tb_kategori_id_seq OWNED BY public.tb_kategori.id;


--
-- Name: tb_kosmetik; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.tb_kosmetik (
    id bigint NOT NULL,
    plu_barang character varying(20) NOT NULL,
    nama_barang character varying(100) NOT NULL,
    total_quantity integer DEFAULT 0 NOT NULL,
    harga_terakhir integer DEFAULT 0 NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: tb_kosmetik_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.tb_kosmetik_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tb_kosmetik_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.tb_kosmetik_id_seq OWNED BY public.tb_kosmetik.id;


--
-- Name: tb_makanan; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.tb_makanan (
    id bigint NOT NULL,
    plu_barang character varying(20) NOT NULL,
    nama_barang character varying(100) NOT NULL,
    total_quantity integer DEFAULT 0 NOT NULL,
    harga_terakhir integer DEFAULT 0 NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: tb_makanan_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.tb_makanan_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tb_makanan_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.tb_makanan_id_seq OWNED BY public.tb_makanan.id;


--
-- Name: tb_minuman; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.tb_minuman (
    id bigint NOT NULL,
    plu_barang character varying(20) NOT NULL,
    nama_barang character varying(100) NOT NULL,
    total_quantity integer DEFAULT 0 NOT NULL,
    harga_terakhir integer DEFAULT 0 NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: tb_minuman_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.tb_minuman_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tb_minuman_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.tb_minuman_id_seq OWNED BY public.tb_minuman.id;


--
-- Name: tb_obat; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.tb_obat (
    id bigint NOT NULL,
    plu_barang character varying(20) NOT NULL,
    nama_barang character varying(255) NOT NULL,
    total_quantity integer DEFAULT 0 NOT NULL,
    harga_terakhir integer DEFAULT 0 NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: tb_obat_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.tb_obat_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tb_obat_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.tb_obat_id_seq OWNED BY public.tb_obat.id;


--
-- Name: tb_pembersih; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.tb_pembersih (
    id bigint NOT NULL,
    plu_barang character varying(20) NOT NULL,
    nama_barang character varying(255) NOT NULL,
    total_quantity integer DEFAULT 0 NOT NULL,
    harga_terakhir integer DEFAULT 0 NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: tb_pembersih_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.tb_pembersih_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tb_pembersih_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.tb_pembersih_id_seq OWNED BY public.tb_pembersih.id;


--
-- Name: tb_perabotan_rumah; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.tb_perabotan_rumah (
    id bigint NOT NULL,
    plu_barang character varying(20) NOT NULL,
    nama_barang character varying(255) NOT NULL,
    total_quantity integer DEFAULT 0 NOT NULL,
    harga_terakhir integer DEFAULT 0 NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: tb_perabotan_rumah_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.tb_perabotan_rumah_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tb_perabotan_rumah_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.tb_perabotan_rumah_id_seq OWNED BY public.tb_perabotan_rumah.id;


--
-- Name: tb_stock; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.tb_stock (
    id bigint NOT NULL,
    plu_barang character varying(20) NOT NULL,
    nama_barang character varying(255) NOT NULL,
    total_quantity integer DEFAULT 0 NOT NULL,
    harga_terakhir integer NOT NULL,
    kategori_id bigint NOT NULL,
    tanggal_expired date,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: tb_stock_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.tb_stock_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tb_stock_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.tb_stock_id_seq OWNED BY public.tb_stock.id;


--
-- Name: transaksi; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.transaksi (
    id bigint NOT NULL,
    grand_total bigint DEFAULT 0 NOT NULL,
    created_at timestamp without time zone DEFAULT now() NOT NULL
);


--
-- Name: transaksi_detail; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.transaksi_detail (
    id bigint NOT NULL,
    transaksi_id bigint NOT NULL,
    plu character varying(50) NOT NULL,
    nama_barang character varying(255) NOT NULL,
    harga bigint NOT NULL,
    qty integer NOT NULL,
    subtotal bigint NOT NULL
);


--
-- Name: transaksi_detail_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.transaksi_detail_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: transaksi_detail_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.transaksi_detail_id_seq OWNED BY public.transaksi_detail.id;


--
-- Name: transaksi_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.transaksi_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: transaksi_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.transaksi_id_seq OWNED BY public.transaksi.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: batch_tb_alat_tulis id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.batch_tb_alat_tulis ALTER COLUMN id SET DEFAULT nextval('public.batch_tb_alat_tulis_id_seq'::regclass);


--
-- Name: batch_tb_bahan_masakan id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.batch_tb_bahan_masakan ALTER COLUMN id SET DEFAULT nextval('public.batch_tb_bahan_masakan_id_seq'::regclass);


--
-- Name: batch_tb_kosmetik id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.batch_tb_kosmetik ALTER COLUMN id SET DEFAULT nextval('public.batch_tb_kosmetik_id_seq'::regclass);


--
-- Name: batch_tb_makanan id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.batch_tb_makanan ALTER COLUMN id SET DEFAULT nextval('public.batch_tb_makanan_id_seq'::regclass);


--
-- Name: batch_tb_minuman id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.batch_tb_minuman ALTER COLUMN id SET DEFAULT nextval('public.batch_tb_minuman_id_seq'::regclass);


--
-- Name: batch_tb_obat id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.batch_tb_obat ALTER COLUMN id SET DEFAULT nextval('public.batch_tb_obat_id_seq'::regclass);


--
-- Name: batch_tb_pembersih id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.batch_tb_pembersih ALTER COLUMN id SET DEFAULT nextval('public.batch_tb_pembersih_id_seq'::regclass);


--
-- Name: batch_tb_perabotan_rumah id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.batch_tb_perabotan_rumah ALTER COLUMN id SET DEFAULT nextval('public.batch_tb_perabotan_rumah_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: pengguna id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pengguna ALTER COLUMN id SET DEFAULT nextval('public.pengguna_id_seq'::regclass);


--
-- Name: tb_alat_tulis id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_alat_tulis ALTER COLUMN id SET DEFAULT nextval('public.tb_alat_tulis_id_seq'::regclass);


--
-- Name: tb_bahan_masakan id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_bahan_masakan ALTER COLUMN id SET DEFAULT nextval('public.tb_bahan_masakan_id_seq'::regclass);


--
-- Name: tb_kategori id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_kategori ALTER COLUMN id SET DEFAULT nextval('public.tb_kategori_id_seq'::regclass);


--
-- Name: tb_kosmetik id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_kosmetik ALTER COLUMN id SET DEFAULT nextval('public.tb_kosmetik_id_seq'::regclass);


--
-- Name: tb_makanan id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_makanan ALTER COLUMN id SET DEFAULT nextval('public.tb_makanan_id_seq'::regclass);


--
-- Name: tb_minuman id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_minuman ALTER COLUMN id SET DEFAULT nextval('public.tb_minuman_id_seq'::regclass);


--
-- Name: tb_obat id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_obat ALTER COLUMN id SET DEFAULT nextval('public.tb_obat_id_seq'::regclass);


--
-- Name: tb_pembersih id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_pembersih ALTER COLUMN id SET DEFAULT nextval('public.tb_pembersih_id_seq'::regclass);


--
-- Name: tb_perabotan_rumah id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_perabotan_rumah ALTER COLUMN id SET DEFAULT nextval('public.tb_perabotan_rumah_id_seq'::regclass);


--
-- Name: tb_stock id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_stock ALTER COLUMN id SET DEFAULT nextval('public.tb_stock_id_seq'::regclass);


--
-- Name: transaksi id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.transaksi ALTER COLUMN id SET DEFAULT nextval('public.transaksi_id_seq'::regclass);


--
-- Name: transaksi_detail id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.transaksi_detail ALTER COLUMN id SET DEFAULT nextval('public.transaksi_detail_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: batch_tb_alat_tulis batch_tb_alat_tulis_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.batch_tb_alat_tulis
    ADD CONSTRAINT batch_tb_alat_tulis_pkey PRIMARY KEY (id);


--
-- Name: batch_tb_bahan_masakan batch_tb_bahan_masakan_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.batch_tb_bahan_masakan
    ADD CONSTRAINT batch_tb_bahan_masakan_pkey PRIMARY KEY (id);


--
-- Name: batch_tb_kosmetik batch_tb_kosmetik_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.batch_tb_kosmetik
    ADD CONSTRAINT batch_tb_kosmetik_pkey PRIMARY KEY (id);


--
-- Name: batch_tb_makanan batch_tb_makanan_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.batch_tb_makanan
    ADD CONSTRAINT batch_tb_makanan_pkey PRIMARY KEY (id);


--
-- Name: batch_tb_minuman batch_tb_minuman_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.batch_tb_minuman
    ADD CONSTRAINT batch_tb_minuman_pkey PRIMARY KEY (id);


--
-- Name: batch_tb_obat batch_tb_obat_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.batch_tb_obat
    ADD CONSTRAINT batch_tb_obat_pkey PRIMARY KEY (id);


--
-- Name: batch_tb_pembersih batch_tb_pembersih_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.batch_tb_pembersih
    ADD CONSTRAINT batch_tb_pembersih_pkey PRIMARY KEY (id);


--
-- Name: batch_tb_perabotan_rumah batch_tb_perabotan_rumah_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.batch_tb_perabotan_rumah
    ADD CONSTRAINT batch_tb_perabotan_rumah_pkey PRIMARY KEY (id);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: pengguna pengguna_email_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pengguna
    ADD CONSTRAINT pengguna_email_key UNIQUE (email);


--
-- Name: pengguna pengguna_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pengguna
    ADD CONSTRAINT pengguna_pkey PRIMARY KEY (id);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: tb_alat_tulis tb_alat_tulis_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_alat_tulis
    ADD CONSTRAINT tb_alat_tulis_pkey PRIMARY KEY (id);


--
-- Name: tb_alat_tulis tb_alat_tulis_plu_barang_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_alat_tulis
    ADD CONSTRAINT tb_alat_tulis_plu_barang_key UNIQUE (plu_barang);


--
-- Name: tb_bahan_masakan tb_bahan_masakan_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_bahan_masakan
    ADD CONSTRAINT tb_bahan_masakan_pkey PRIMARY KEY (id);


--
-- Name: tb_bahan_masakan tb_bahan_masakan_plu_barang_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_bahan_masakan
    ADD CONSTRAINT tb_bahan_masakan_plu_barang_key UNIQUE (plu_barang);


--
-- Name: tb_kategori tb_kategori_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_kategori
    ADD CONSTRAINT tb_kategori_pkey PRIMARY KEY (id);


--
-- Name: tb_kosmetik tb_kosmetik_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_kosmetik
    ADD CONSTRAINT tb_kosmetik_pkey PRIMARY KEY (id);


--
-- Name: tb_kosmetik tb_kosmetik_plu_barang_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_kosmetik
    ADD CONSTRAINT tb_kosmetik_plu_barang_key UNIQUE (plu_barang);


--
-- Name: tb_makanan tb_makanan_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_makanan
    ADD CONSTRAINT tb_makanan_pkey PRIMARY KEY (id);


--
-- Name: tb_makanan tb_makanan_plu_barang_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_makanan
    ADD CONSTRAINT tb_makanan_plu_barang_key UNIQUE (plu_barang);


--
-- Name: tb_minuman tb_minuman_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_minuman
    ADD CONSTRAINT tb_minuman_pkey PRIMARY KEY (id);


--
-- Name: tb_minuman tb_minuman_plu_barang_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_minuman
    ADD CONSTRAINT tb_minuman_plu_barang_key UNIQUE (plu_barang);


--
-- Name: tb_obat tb_obat_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_obat
    ADD CONSTRAINT tb_obat_pkey PRIMARY KEY (id);


--
-- Name: tb_obat tb_obat_plu_barang_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_obat
    ADD CONSTRAINT tb_obat_plu_barang_key UNIQUE (plu_barang);


--
-- Name: tb_pembersih tb_pembersih_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_pembersih
    ADD CONSTRAINT tb_pembersih_pkey PRIMARY KEY (id);


--
-- Name: tb_pembersih tb_pembersih_plu_barang_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_pembersih
    ADD CONSTRAINT tb_pembersih_plu_barang_key UNIQUE (plu_barang);


--
-- Name: tb_perabotan_rumah tb_perabotan_rumah_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_perabotan_rumah
    ADD CONSTRAINT tb_perabotan_rumah_pkey PRIMARY KEY (id);


--
-- Name: tb_perabotan_rumah tb_perabotan_rumah_plu_barang_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_perabotan_rumah
    ADD CONSTRAINT tb_perabotan_rumah_plu_barang_key UNIQUE (plu_barang);


--
-- Name: tb_stock tb_stock_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_stock
    ADD CONSTRAINT tb_stock_pkey PRIMARY KEY (id);


--
-- Name: transaksi_detail transaksi_detail_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.transaksi_detail
    ADD CONSTRAINT transaksi_detail_pkey PRIMARY KEY (id);


--
-- Name: transaksi transaksi_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.transaksi
    ADD CONSTRAINT transaksi_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: batch_tb_alat_tulis fk_batch_alat_tulis; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.batch_tb_alat_tulis
    ADD CONSTRAINT fk_batch_alat_tulis FOREIGN KEY (barang_id) REFERENCES public.tb_alat_tulis(id) ON DELETE CASCADE;


--
-- Name: batch_tb_bahan_masakan fk_batch_bahan_masakan; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.batch_tb_bahan_masakan
    ADD CONSTRAINT fk_batch_bahan_masakan FOREIGN KEY (barang_id) REFERENCES public.tb_bahan_masakan(id) ON DELETE CASCADE;


--
-- Name: batch_tb_kosmetik fk_batch_kosmetik; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.batch_tb_kosmetik
    ADD CONSTRAINT fk_batch_kosmetik FOREIGN KEY (barang_id) REFERENCES public.tb_kosmetik(id) ON DELETE CASCADE;


--
-- Name: batch_tb_makanan fk_batch_makanan; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.batch_tb_makanan
    ADD CONSTRAINT fk_batch_makanan FOREIGN KEY (barang_id) REFERENCES public.tb_makanan(id) ON DELETE CASCADE;


--
-- Name: batch_tb_minuman fk_batch_minuman; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.batch_tb_minuman
    ADD CONSTRAINT fk_batch_minuman FOREIGN KEY (barang_id) REFERENCES public.tb_minuman(id) ON DELETE CASCADE;


--
-- Name: batch_tb_obat fk_batch_obat; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.batch_tb_obat
    ADD CONSTRAINT fk_batch_obat FOREIGN KEY (barang_id) REFERENCES public.tb_obat(id) ON DELETE CASCADE;


--
-- Name: batch_tb_pembersih fk_batch_tb_pembersih; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.batch_tb_pembersih
    ADD CONSTRAINT fk_batch_tb_pembersih FOREIGN KEY (barang_id) REFERENCES public.tb_pembersih(id) ON DELETE CASCADE;


--
-- Name: batch_tb_perabotan_rumah fk_batch_tb_perabotan_rumah; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.batch_tb_perabotan_rumah
    ADD CONSTRAINT fk_batch_tb_perabotan_rumah FOREIGN KEY (barang_id) REFERENCES public.tb_perabotan_rumah(id) ON DELETE CASCADE;


--
-- Name: tb_stock fk_tb_stock_kategori; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.tb_stock
    ADD CONSTRAINT fk_tb_stock_kategori FOREIGN KEY (kategori_id) REFERENCES public.tb_kategori(id) ON DELETE RESTRICT;


--
-- Name: transaksi_detail transaksi_detail_transaksi_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.transaksi_detail
    ADD CONSTRAINT transaksi_detail_transaksi_id_fkey FOREIGN KEY (transaksi_id) REFERENCES public.transaksi(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

\unrestrict HtiaVSZFDcZ03Ncb9GvjXQHheztb64bIzgSWEisVRx4Rp7vzGLpnji8jVG4gpR8

