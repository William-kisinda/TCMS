PGDMP         7    	        	    {            TCMS    15.4    15.3 �    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    74010    TCMS    DATABASE     |   CREATE DATABASE "TCMS" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_Tanzania.1252';
    DROP DATABASE "TCMS";
                postgres    false            �            1259    74063 	   customers    TABLE     �   CREATE TABLE public.customers (
    id bigint NOT NULL,
    full_name character varying(255) NOT NULL,
    phone text NOT NULL,
    address text NOT NULL
);
    DROP TABLE public.customers;
       public         heap    postgres    false            �            1259    74062    customers_id_seq    SEQUENCE     y   CREATE SEQUENCE public.customers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.customers_id_seq;
       public          postgres    false    224                        0    0    customers_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.customers_id_seq OWNED BY public.customers.id;
          public          postgres    false    223            �            1259    98346    debt    TABLE     �   CREATE TABLE public.debt (
    id bigint NOT NULL,
    description text NOT NULL,
    amount bigint NOT NULL,
    "reductionRate" double precision NOT NULL,
    meters_id bigint NOT NULL
);
    DROP TABLE public.debt;
       public         heap    postgres    false            �            1259    98345    debt_id_seq    SEQUENCE     t   CREATE SEQUENCE public.debt_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 "   DROP SEQUENCE public.debt_id_seq;
       public          postgres    false    250                       0    0    debt_id_seq    SEQUENCE OWNED BY     ;   ALTER SEQUENCE public.debt_id_seq OWNED BY public.debt.id;
          public          postgres    false    249            �            1259    98376    debts    TABLE     X  CREATE TABLE public.debts (
    id bigint NOT NULL,
    "reductionRate" numeric(5,2) NOT NULL,
    "debtAmount" numeric(10,2) NOT NULL,
    description text NOT NULL,
    "remainingDebtAmount" numeric(10,2) NOT NULL,
    meters_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.debts;
       public         heap    postgres    false            �            1259    98375    debts_id_seq    SEQUENCE     u   CREATE SEQUENCE public.debts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.debts_id_seq;
       public          postgres    false    252                       0    0    debts_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.debts_id_seq OWNED BY public.debts.id;
          public          postgres    false    251            �            1259    74039    failed_jobs    TABLE     &  CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);
    DROP TABLE public.failed_jobs;
       public         heap    postgres    false            �            1259    74038    failed_jobs_id_seq    SEQUENCE     {   CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.failed_jobs_id_seq;
       public          postgres    false    220                       0    0    failed_jobs_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;
          public          postgres    false    219            �            1259    74072    meters    TABLE     �   CREATE TABLE public.meters (
    id bigint NOT NULL,
    meternumber bigint NOT NULL,
    customers_id bigint NOT NULL,
    status character varying(255) NOT NULL,
    utility_provider_id bigint
);
    DROP TABLE public.meters;
       public         heap    postgres    false            �            1259    74071    meters_id_seq    SEQUENCE     v   CREATE SEQUENCE public.meters_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 $   DROP SEQUENCE public.meters_id_seq;
       public          postgres    false    226                       0    0    meters_id_seq    SEQUENCE OWNED BY     ?   ALTER SEQUENCE public.meters_id_seq OWNED BY public.meters.id;
          public          postgres    false    225            �            1259    74012 
   migrations    TABLE     �   CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);
    DROP TABLE public.migrations;
       public         heap    postgres    false            �            1259    74011    migrations_id_seq    SEQUENCE     �   CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.migrations_id_seq;
       public          postgres    false    215                       0    0    migrations_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;
          public          postgres    false    214            �            1259    81954    model_has_permissions    TABLE     �   CREATE TABLE public.model_has_permissions (
    permission_id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL
);
 )   DROP TABLE public.model_has_permissions;
       public         heap    postgres    false            �            1259    81965    model_has_roles    TABLE     �   CREATE TABLE public.model_has_roles (
    role_id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL
);
 #   DROP TABLE public.model_has_roles;
       public         heap    postgres    false                        1259    106639    notifications    TABLE     �   CREATE TABLE public.notifications (
    id bigint NOT NULL,
    token text NOT NULL,
    meternumber bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 !   DROP TABLE public.notifications;
       public         heap    postgres    false            �            1259    106638    notifications_id_seq    SEQUENCE     }   CREATE SEQUENCE public.notifications_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.notifications_id_seq;
       public          postgres    false    256                       0    0    notifications_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.notifications_id_seq OWNED BY public.notifications.id;
          public          postgres    false    255            �            1259    90132    oauth_access_tokens    TABLE     d  CREATE TABLE public.oauth_access_tokens (
    id character varying(100) NOT NULL,
    user_id bigint,
    client_id bigint NOT NULL,
    name character varying(255),
    scopes text,
    revoked boolean NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone
);
 '   DROP TABLE public.oauth_access_tokens;
       public         heap    postgres    false            �            1259    90124    oauth_auth_codes    TABLE     �   CREATE TABLE public.oauth_auth_codes (
    id character varying(100) NOT NULL,
    user_id bigint NOT NULL,
    client_id bigint NOT NULL,
    scopes text,
    revoked boolean NOT NULL,
    expires_at timestamp(0) without time zone
);
 $   DROP TABLE public.oauth_auth_codes;
       public         heap    postgres    false            �            1259    90147    oauth_clients    TABLE     �  CREATE TABLE public.oauth_clients (
    id bigint NOT NULL,
    user_id bigint,
    name character varying(255) NOT NULL,
    secret character varying(100),
    provider character varying(255),
    redirect text NOT NULL,
    personal_access_client boolean NOT NULL,
    password_client boolean NOT NULL,
    revoked boolean NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 !   DROP TABLE public.oauth_clients;
       public         heap    postgres    false            �            1259    90146    oauth_clients_id_seq    SEQUENCE     }   CREATE SEQUENCE public.oauth_clients_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.oauth_clients_id_seq;
       public          postgres    false    246                       0    0    oauth_clients_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.oauth_clients_id_seq OWNED BY public.oauth_clients.id;
          public          postgres    false    245            �            1259    90157    oauth_personal_access_clients    TABLE     �   CREATE TABLE public.oauth_personal_access_clients (
    id bigint NOT NULL,
    client_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 1   DROP TABLE public.oauth_personal_access_clients;
       public         heap    postgres    false            �            1259    90156 $   oauth_personal_access_clients_id_seq    SEQUENCE     �   CREATE SEQUENCE public.oauth_personal_access_clients_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ;   DROP SEQUENCE public.oauth_personal_access_clients_id_seq;
       public          postgres    false    248                       0    0 $   oauth_personal_access_clients_id_seq    SEQUENCE OWNED BY     m   ALTER SEQUENCE public.oauth_personal_access_clients_id_seq OWNED BY public.oauth_personal_access_clients.id;
          public          postgres    false    247            �            1259    90140    oauth_refresh_tokens    TABLE     �   CREATE TABLE public.oauth_refresh_tokens (
    id character varying(100) NOT NULL,
    access_token_id character varying(100) NOT NULL,
    revoked boolean NOT NULL,
    expires_at timestamp(0) without time zone
);
 (   DROP TABLE public.oauth_refresh_tokens;
       public         heap    postgres    false            �            1259    74031    password_reset_tokens    TABLE     �   CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);
 )   DROP TABLE public.password_reset_tokens;
       public         heap    postgres    false            �            1259    81933    permissions    TABLE     �   CREATE TABLE public.permissions (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    guard_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.permissions;
       public         heap    postgres    false            �            1259    81932    permissions_id_seq    SEQUENCE     {   CREATE SEQUENCE public.permissions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.permissions_id_seq;
       public          postgres    false    236            	           0    0    permissions_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.permissions_id_seq OWNED BY public.permissions.id;
          public          postgres    false    235            �            1259    74051    personal_access_tokens    TABLE     �  CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 *   DROP TABLE public.personal_access_tokens;
       public         heap    postgres    false            �            1259    74050    personal_access_tokens_id_seq    SEQUENCE     �   CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 4   DROP SEQUENCE public.personal_access_tokens_id_seq;
       public          postgres    false    222            
           0    0    personal_access_tokens_id_seq    SEQUENCE OWNED BY     _   ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;
          public          postgres    false    221            �            1259    74112    provider_categories    TABLE     �   CREATE TABLE public.provider_categories (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    code character varying(255) NOT NULL
);
 '   DROP TABLE public.provider_categories;
       public         heap    postgres    false            �            1259    74111    provider_categories_id_seq    SEQUENCE     �   CREATE SEQUENCE public.provider_categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 1   DROP SEQUENCE public.provider_categories_id_seq;
       public          postgres    false    232                       0    0    provider_categories_id_seq    SEQUENCE OWNED BY     Y   ALTER SEQUENCE public.provider_categories_id_seq OWNED BY public.provider_categories.id;
          public          postgres    false    231            �            1259    81976    role_has_permissions    TABLE     m   CREATE TABLE public.role_has_permissions (
    permission_id bigint NOT NULL,
    role_id bigint NOT NULL
);
 (   DROP TABLE public.role_has_permissions;
       public         heap    postgres    false            �            1259    81944    roles    TABLE     �   CREATE TABLE public.roles (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    guard_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.roles;
       public         heap    postgres    false            �            1259    81943    roles_id_seq    SEQUENCE     u   CREATE SEQUENCE public.roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.roles_id_seq;
       public          postgres    false    238                       0    0    roles_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;
          public          postgres    false    237            �            1259    74086    tariffs    TABLE     �   CREATE TABLE public.tariffs (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    code character varying(255) NOT NULL,
    "percentageAmount" integer NOT NULL,
    value integer NOT NULL
);
    DROP TABLE public.tariffs;
       public         heap    postgres    false            �            1259    74085    tariffs_id_seq    SEQUENCE     w   CREATE SEQUENCE public.tariffs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.tariffs_id_seq;
       public          postgres    false    228                       0    0    tariffs_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.tariffs_id_seq OWNED BY public.tariffs.id;
          public          postgres    false    227            �            1259    74095    token_manage    TABLE     �   CREATE TABLE public.token_manage (
    id bigint NOT NULL,
    meter_id bigint NOT NULL,
    token character varying(255) NOT NULL,
    generation_date timestamp(0) without time zone NOT NULL,
    tariff_id bigint NOT NULL
);
     DROP TABLE public.token_manage;
       public         heap    postgres    false            �            1259    74094    token_manage_id_seq    SEQUENCE     |   CREATE SEQUENCE public.token_manage_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.token_manage_id_seq;
       public          postgres    false    230                       0    0    token_manage_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE public.token_manage_id_seq OWNED BY public.token_manage.id;
          public          postgres    false    229            �            1259    74019    users    TABLE     &  CREATE TABLE public.users (
    id bigint NOT NULL,
    full_name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    phone_number bigint NOT NULL,
    password character varying(255) NOT NULL,
    utility_provider_model_id bigint,
    utility_provider_id bigint
);
    DROP TABLE public.users;
       public         heap    postgres    false            �            1259    74018    users_id_seq    SEQUENCE     u   CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.users_id_seq;
       public          postgres    false    217                       0    0    users_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;
          public          postgres    false    216            �            1259    74123    utility_providers    TABLE     	  CREATE TABLE public.utility_providers (
    id bigint NOT NULL,
    provider_name character varying(255) NOT NULL,
    provider_code character varying(255) NOT NULL,
    provider_status character varying(255) NOT NULL,
    provider_categories_id bigint NOT NULL
);
 %   DROP TABLE public.utility_providers;
       public         heap    postgres    false            �            1259    74122    utility_providers_id_seq    SEQUENCE     �   CREATE SEQUENCE public.utility_providers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE public.utility_providers_id_seq;
       public          postgres    false    234                       0    0    utility_providers_id_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE public.utility_providers_id_seq OWNED BY public.utility_providers.id;
          public          postgres    false    233            �            1259    106622    utility_providers_tariffs    TABLE     �   CREATE TABLE public.utility_providers_tariffs (
    id integer NOT NULL,
    utility_provider_id bigint,
    tariff_id bigint
);
 -   DROP TABLE public.utility_providers_tariffs;
       public         heap    postgres    false            �            1259    106621     utility_providers_tariffs_id_seq    SEQUENCE     �   CREATE SEQUENCE public.utility_providers_tariffs_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 7   DROP SEQUENCE public.utility_providers_tariffs_id_seq;
       public          postgres    false    254                       0    0     utility_providers_tariffs_id_seq    SEQUENCE OWNED BY     e   ALTER SEQUENCE public.utility_providers_tariffs_id_seq OWNED BY public.utility_providers_tariffs.id;
          public          postgres    false    253            �           2604    74066    customers id    DEFAULT     l   ALTER TABLE ONLY public.customers ALTER COLUMN id SET DEFAULT nextval('public.customers_id_seq'::regclass);
 ;   ALTER TABLE public.customers ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    223    224    224            �           2604    98349    debt id    DEFAULT     b   ALTER TABLE ONLY public.debt ALTER COLUMN id SET DEFAULT nextval('public.debt_id_seq'::regclass);
 6   ALTER TABLE public.debt ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    249    250    250            �           2604    98379    debts id    DEFAULT     d   ALTER TABLE ONLY public.debts ALTER COLUMN id SET DEFAULT nextval('public.debts_id_seq'::regclass);
 7   ALTER TABLE public.debts ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    251    252    252            �           2604    74042    failed_jobs id    DEFAULT     p   ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);
 =   ALTER TABLE public.failed_jobs ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    219    220    220            �           2604    74075 	   meters id    DEFAULT     f   ALTER TABLE ONLY public.meters ALTER COLUMN id SET DEFAULT nextval('public.meters_id_seq'::regclass);
 8   ALTER TABLE public.meters ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    225    226    226            �           2604    74015    migrations id    DEFAULT     n   ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);
 <   ALTER TABLE public.migrations ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    215    214    215            �           2604    106642    notifications id    DEFAULT     t   ALTER TABLE ONLY public.notifications ALTER COLUMN id SET DEFAULT nextval('public.notifications_id_seq'::regclass);
 ?   ALTER TABLE public.notifications ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    255    256    256            �           2604    90150    oauth_clients id    DEFAULT     t   ALTER TABLE ONLY public.oauth_clients ALTER COLUMN id SET DEFAULT nextval('public.oauth_clients_id_seq'::regclass);
 ?   ALTER TABLE public.oauth_clients ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    246    245    246            �           2604    90160     oauth_personal_access_clients id    DEFAULT     �   ALTER TABLE ONLY public.oauth_personal_access_clients ALTER COLUMN id SET DEFAULT nextval('public.oauth_personal_access_clients_id_seq'::regclass);
 O   ALTER TABLE public.oauth_personal_access_clients ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    248    247    248            �           2604    81936    permissions id    DEFAULT     p   ALTER TABLE ONLY public.permissions ALTER COLUMN id SET DEFAULT nextval('public.permissions_id_seq'::regclass);
 =   ALTER TABLE public.permissions ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    236    235    236            �           2604    74054    personal_access_tokens id    DEFAULT     �   ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);
 H   ALTER TABLE public.personal_access_tokens ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    221    222    222            �           2604    74115    provider_categories id    DEFAULT     �   ALTER TABLE ONLY public.provider_categories ALTER COLUMN id SET DEFAULT nextval('public.provider_categories_id_seq'::regclass);
 E   ALTER TABLE public.provider_categories ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    232    231    232            �           2604    81947    roles id    DEFAULT     d   ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);
 7   ALTER TABLE public.roles ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    237    238    238            �           2604    74089 
   tariffs id    DEFAULT     h   ALTER TABLE ONLY public.tariffs ALTER COLUMN id SET DEFAULT nextval('public.tariffs_id_seq'::regclass);
 9   ALTER TABLE public.tariffs ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    228    227    228            �           2604    74098    token_manage id    DEFAULT     r   ALTER TABLE ONLY public.token_manage ALTER COLUMN id SET DEFAULT nextval('public.token_manage_id_seq'::regclass);
 >   ALTER TABLE public.token_manage ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    230    229    230            �           2604    74022    users id    DEFAULT     d   ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);
 7   ALTER TABLE public.users ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    217    216    217            �           2604    74126    utility_providers id    DEFAULT     |   ALTER TABLE ONLY public.utility_providers ALTER COLUMN id SET DEFAULT nextval('public.utility_providers_id_seq'::regclass);
 C   ALTER TABLE public.utility_providers ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    234    233    234            �           2604    106625    utility_providers_tariffs id    DEFAULT     �   ALTER TABLE ONLY public.utility_providers_tariffs ALTER COLUMN id SET DEFAULT nextval('public.utility_providers_tariffs_id_seq'::regclass);
 K   ALTER TABLE public.utility_providers_tariffs ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    253    254    254            �          0    74063 	   customers 
   TABLE DATA           B   COPY public.customers (id, full_name, phone, address) FROM stdin;
    public          postgres    false    224   ��       �          0    98346    debt 
   TABLE DATA           S   COPY public.debt (id, description, amount, "reductionRate", meters_id) FROM stdin;
    public          postgres    false    250   l�       �          0    98376    debts 
   TABLE DATA           �   COPY public.debts (id, "reductionRate", "debtAmount", description, "remainingDebtAmount", meters_id, created_at, updated_at) FROM stdin;
    public          postgres    false    252   ��       �          0    74039    failed_jobs 
   TABLE DATA           a   COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
    public          postgres    false    220   ��       �          0    74072    meters 
   TABLE DATA           \   COPY public.meters (id, meternumber, customers_id, status, utility_provider_id) FROM stdin;
    public          postgres    false    226   �       �          0    74012 
   migrations 
   TABLE DATA           :   COPY public.migrations (id, migration, batch) FROM stdin;
    public          postgres    false    215   ^�       �          0    81954    model_has_permissions 
   TABLE DATA           T   COPY public.model_has_permissions (permission_id, model_type, model_id) FROM stdin;
    public          postgres    false    239   $�       �          0    81965    model_has_roles 
   TABLE DATA           H   COPY public.model_has_roles (role_id, model_type, model_id) FROM stdin;
    public          postgres    false    240   A�       �          0    106639    notifications 
   TABLE DATA           W   COPY public.notifications (id, token, meternumber, created_at, updated_at) FROM stdin;
    public          postgres    false    256   ��       �          0    90132    oauth_access_tokens 
   TABLE DATA           �   COPY public.oauth_access_tokens (id, user_id, client_id, name, scopes, revoked, created_at, updated_at, expires_at) FROM stdin;
    public          postgres    false    243   ��       �          0    90124    oauth_auth_codes 
   TABLE DATA           _   COPY public.oauth_auth_codes (id, user_id, client_id, scopes, revoked, expires_at) FROM stdin;
    public          postgres    false    242   ��       �          0    90147    oauth_clients 
   TABLE DATA           �   COPY public.oauth_clients (id, user_id, name, secret, provider, redirect, personal_access_client, password_client, revoked, created_at, updated_at) FROM stdin;
    public          postgres    false    246   �       �          0    90157    oauth_personal_access_clients 
   TABLE DATA           ^   COPY public.oauth_personal_access_clients (id, client_id, created_at, updated_at) FROM stdin;
    public          postgres    false    248   ��       �          0    90140    oauth_refresh_tokens 
   TABLE DATA           X   COPY public.oauth_refresh_tokens (id, access_token_id, revoked, expires_at) FROM stdin;
    public          postgres    false    244   �       �          0    74031    password_reset_tokens 
   TABLE DATA           I   COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
    public          postgres    false    218   /�       �          0    81933    permissions 
   TABLE DATA           S   COPY public.permissions (id, name, guard_name, created_at, updated_at) FROM stdin;
    public          postgres    false    236   L�       �          0    74051    personal_access_tokens 
   TABLE DATA           �   COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, expires_at, created_at, updated_at) FROM stdin;
    public          postgres    false    222   <�       �          0    74112    provider_categories 
   TABLE DATA           =   COPY public.provider_categories (id, name, code) FROM stdin;
    public          postgres    false    232   Y�       �          0    81976    role_has_permissions 
   TABLE DATA           F   COPY public.role_has_permissions (permission_id, role_id) FROM stdin;
    public          postgres    false    241   ��       �          0    81944    roles 
   TABLE DATA           M   COPY public.roles (id, name, guard_name, created_at, updated_at) FROM stdin;
    public          postgres    false    238   '�       �          0    74086    tariffs 
   TABLE DATA           L   COPY public.tariffs (id, name, code, "percentageAmount", value) FROM stdin;
    public          postgres    false    228   ��       �          0    74095    token_manage 
   TABLE DATA           W   COPY public.token_manage (id, meter_id, token, generation_date, tariff_id) FROM stdin;
    public          postgres    false    230   ��       �          0    74019    users 
   TABLE DATA           }   COPY public.users (id, full_name, email, phone_number, password, utility_provider_model_id, utility_provider_id) FROM stdin;
    public          postgres    false    217   ��       �          0    74123    utility_providers 
   TABLE DATA           v   COPY public.utility_providers (id, provider_name, provider_code, provider_status, provider_categories_id) FROM stdin;
    public          postgres    false    234   ��       �          0    106622    utility_providers_tariffs 
   TABLE DATA           W   COPY public.utility_providers_tariffs (id, utility_provider_id, tariff_id) FROM stdin;
    public          postgres    false    254   B�                  0    0    customers_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.customers_id_seq', 16, true);
          public          postgres    false    223                       0    0    debt_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.debt_id_seq', 45, true);
          public          postgres    false    249                       0    0    debts_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.debts_id_seq', 20, true);
          public          postgres    false    251                       0    0    failed_jobs_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);
          public          postgres    false    219                       0    0    meters_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.meters_id_seq', 15, true);
          public          postgres    false    225                       0    0    migrations_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.migrations_id_seq', 33, true);
          public          postgres    false    214                       0    0    notifications_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.notifications_id_seq', 4, true);
          public          postgres    false    255                       0    0    oauth_clients_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.oauth_clients_id_seq', 2, true);
          public          postgres    false    245                       0    0 $   oauth_personal_access_clients_id_seq    SEQUENCE SET     R   SELECT pg_catalog.setval('public.oauth_personal_access_clients_id_seq', 1, true);
          public          postgres    false    247                       0    0    permissions_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.permissions_id_seq', 25, true);
          public          postgres    false    235                       0    0    personal_access_tokens_id_seq    SEQUENCE SET     L   SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 1, false);
          public          postgres    false    221                       0    0    provider_categories_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.provider_categories_id_seq', 8, true);
          public          postgres    false    231                       0    0    roles_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.roles_id_seq', 8, true);
          public          postgres    false    237                       0    0    tariffs_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.tariffs_id_seq', 10, true);
          public          postgres    false    227                        0    0    token_manage_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.token_manage_id_seq', 18, true);
          public          postgres    false    229            !           0    0    users_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.users_id_seq', 28, true);
          public          postgres    false    216            "           0    0    utility_providers_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('public.utility_providers_id_seq', 19, true);
          public          postgres    false    233            #           0    0     utility_providers_tariffs_id_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('public.utility_providers_tariffs_id_seq', 5, true);
          public          postgres    false    253            �           2606    74070    customers customers_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.customers
    ADD CONSTRAINT customers_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.customers DROP CONSTRAINT customers_pkey;
       public            postgres    false    224            +           2606    98353    debt debt_pkey 
   CONSTRAINT     L   ALTER TABLE ONLY public.debt
    ADD CONSTRAINT debt_pkey PRIMARY KEY (id);
 8   ALTER TABLE ONLY public.debt DROP CONSTRAINT debt_pkey;
       public            postgres    false    250            -           2606    98383    debts debts_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.debts
    ADD CONSTRAINT debts_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.debts DROP CONSTRAINT debts_pkey;
       public            postgres    false    252            �           2606    74047    failed_jobs failed_jobs_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.failed_jobs DROP CONSTRAINT failed_jobs_pkey;
       public            postgres    false    220            �           2606    74049 #   failed_jobs failed_jobs_uuid_unique 
   CONSTRAINT     ^   ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);
 M   ALTER TABLE ONLY public.failed_jobs DROP CONSTRAINT failed_jobs_uuid_unique;
       public            postgres    false    220            �           2606    74084 !   meters meters_meter_number_unique 
   CONSTRAINT     c   ALTER TABLE ONLY public.meters
    ADD CONSTRAINT meters_meter_number_unique UNIQUE (meternumber);
 K   ALTER TABLE ONLY public.meters DROP CONSTRAINT meters_meter_number_unique;
       public            postgres    false    226                       2606    74077    meters meters_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public.meters
    ADD CONSTRAINT meters_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.meters DROP CONSTRAINT meters_pkey;
       public            postgres    false    226            �           2606    74017    migrations migrations_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.migrations DROP CONSTRAINT migrations_pkey;
       public            postgres    false    215                       2606    81964 0   model_has_permissions model_has_permissions_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY public.model_has_permissions
    ADD CONSTRAINT model_has_permissions_pkey PRIMARY KEY (permission_id, model_id, model_type);
 Z   ALTER TABLE ONLY public.model_has_permissions DROP CONSTRAINT model_has_permissions_pkey;
       public            postgres    false    239    239    239                       2606    81975 $   model_has_roles model_has_roles_pkey 
   CONSTRAINT     }   ALTER TABLE ONLY public.model_has_roles
    ADD CONSTRAINT model_has_roles_pkey PRIMARY KEY (role_id, model_id, model_type);
 N   ALTER TABLE ONLY public.model_has_roles DROP CONSTRAINT model_has_roles_pkey;
       public            postgres    false    240    240    240            1           2606    106646     notifications notifications_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.notifications
    ADD CONSTRAINT notifications_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.notifications DROP CONSTRAINT notifications_pkey;
       public            postgres    false    256                        2606    90138 ,   oauth_access_tokens oauth_access_tokens_pkey 
   CONSTRAINT     j   ALTER TABLE ONLY public.oauth_access_tokens
    ADD CONSTRAINT oauth_access_tokens_pkey PRIMARY KEY (id);
 V   ALTER TABLE ONLY public.oauth_access_tokens DROP CONSTRAINT oauth_access_tokens_pkey;
       public            postgres    false    243                       2606    90130 &   oauth_auth_codes oauth_auth_codes_pkey 
   CONSTRAINT     d   ALTER TABLE ONLY public.oauth_auth_codes
    ADD CONSTRAINT oauth_auth_codes_pkey PRIMARY KEY (id);
 P   ALTER TABLE ONLY public.oauth_auth_codes DROP CONSTRAINT oauth_auth_codes_pkey;
       public            postgres    false    242            &           2606    90154     oauth_clients oauth_clients_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.oauth_clients
    ADD CONSTRAINT oauth_clients_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.oauth_clients DROP CONSTRAINT oauth_clients_pkey;
       public            postgres    false    246            )           2606    90162 @   oauth_personal_access_clients oauth_personal_access_clients_pkey 
   CONSTRAINT     ~   ALTER TABLE ONLY public.oauth_personal_access_clients
    ADD CONSTRAINT oauth_personal_access_clients_pkey PRIMARY KEY (id);
 j   ALTER TABLE ONLY public.oauth_personal_access_clients DROP CONSTRAINT oauth_personal_access_clients_pkey;
       public            postgres    false    248            $           2606    90144 .   oauth_refresh_tokens oauth_refresh_tokens_pkey 
   CONSTRAINT     l   ALTER TABLE ONLY public.oauth_refresh_tokens
    ADD CONSTRAINT oauth_refresh_tokens_pkey PRIMARY KEY (id);
 X   ALTER TABLE ONLY public.oauth_refresh_tokens DROP CONSTRAINT oauth_refresh_tokens_pkey;
       public            postgres    false    244            �           2606    74037 0   password_reset_tokens password_reset_tokens_pkey 
   CONSTRAINT     q   ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);
 Z   ALTER TABLE ONLY public.password_reset_tokens DROP CONSTRAINT password_reset_tokens_pkey;
       public            postgres    false    218                       2606    81942 .   permissions permissions_name_guard_name_unique 
   CONSTRAINT     u   ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_name_guard_name_unique UNIQUE (name, guard_name);
 X   ALTER TABLE ONLY public.permissions DROP CONSTRAINT permissions_name_guard_name_unique;
       public            postgres    false    236    236                       2606    81940    permissions permissions_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.permissions DROP CONSTRAINT permissions_pkey;
       public            postgres    false    236            �           2606    74058 2   personal_access_tokens personal_access_tokens_pkey 
   CONSTRAINT     p   ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);
 \   ALTER TABLE ONLY public.personal_access_tokens DROP CONSTRAINT personal_access_tokens_pkey;
       public            postgres    false    222            �           2606    74061 :   personal_access_tokens personal_access_tokens_token_unique 
   CONSTRAINT     v   ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);
 d   ALTER TABLE ONLY public.personal_access_tokens DROP CONSTRAINT personal_access_tokens_token_unique;
       public            postgres    false    222                       2606    74121 3   provider_categories provider_categories_code_unique 
   CONSTRAINT     n   ALTER TABLE ONLY public.provider_categories
    ADD CONSTRAINT provider_categories_code_unique UNIQUE (code);
 ]   ALTER TABLE ONLY public.provider_categories DROP CONSTRAINT provider_categories_code_unique;
       public            postgres    false    232            	           2606    74119 ,   provider_categories provider_categories_pkey 
   CONSTRAINT     j   ALTER TABLE ONLY public.provider_categories
    ADD CONSTRAINT provider_categories_pkey PRIMARY KEY (id);
 V   ALTER TABLE ONLY public.provider_categories DROP CONSTRAINT provider_categories_pkey;
       public            postgres    false    232                       2606    81990 .   role_has_permissions role_has_permissions_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_pkey PRIMARY KEY (permission_id, role_id);
 X   ALTER TABLE ONLY public.role_has_permissions DROP CONSTRAINT role_has_permissions_pkey;
       public            postgres    false    241    241                       2606    81953 "   roles roles_name_guard_name_unique 
   CONSTRAINT     i   ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_name_guard_name_unique UNIQUE (name, guard_name);
 L   ALTER TABLE ONLY public.roles DROP CONSTRAINT roles_name_guard_name_unique;
       public            postgres    false    238    238                       2606    81951    roles roles_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.roles DROP CONSTRAINT roles_pkey;
       public            postgres    false    238                       2606    74093    tariffs tariffs_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.tariffs
    ADD CONSTRAINT tariffs_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.tariffs DROP CONSTRAINT tariffs_pkey;
       public            postgres    false    228                       2606    74100    token_manage token_manage_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.token_manage
    ADD CONSTRAINT token_manage_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.token_manage DROP CONSTRAINT token_manage_pkey;
       public            postgres    false    230            �           2606    74028    users users_email_unique 
   CONSTRAINT     T   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);
 B   ALTER TABLE ONLY public.users DROP CONSTRAINT users_email_unique;
       public            postgres    false    217            �           2606    74030    users users_phone_number_unique 
   CONSTRAINT     b   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_phone_number_unique UNIQUE (phone_number);
 I   ALTER TABLE ONLY public.users DROP CONSTRAINT users_phone_number_unique;
       public            postgres    false    217            �           2606    74026    users users_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.users DROP CONSTRAINT users_pkey;
       public            postgres    false    217                       2606    74130 (   utility_providers utility_providers_pkey 
   CONSTRAINT     f   ALTER TABLE ONLY public.utility_providers
    ADD CONSTRAINT utility_providers_pkey PRIMARY KEY (id);
 R   ALTER TABLE ONLY public.utility_providers DROP CONSTRAINT utility_providers_pkey;
       public            postgres    false    234            /           2606    106627 8   utility_providers_tariffs utility_providers_tariffs_pkey 
   CONSTRAINT     v   ALTER TABLE ONLY public.utility_providers_tariffs
    ADD CONSTRAINT utility_providers_tariffs_pkey PRIMARY KEY (id);
 b   ALTER TABLE ONLY public.utility_providers_tariffs DROP CONSTRAINT utility_providers_tariffs_pkey;
       public            postgres    false    254                       1259    81957 /   model_has_permissions_model_id_model_type_index    INDEX     �   CREATE INDEX model_has_permissions_model_id_model_type_index ON public.model_has_permissions USING btree (model_id, model_type);
 C   DROP INDEX public.model_has_permissions_model_id_model_type_index;
       public            postgres    false    239    239                       1259    81968 )   model_has_roles_model_id_model_type_index    INDEX     u   CREATE INDEX model_has_roles_model_id_model_type_index ON public.model_has_roles USING btree (model_id, model_type);
 =   DROP INDEX public.model_has_roles_model_id_model_type_index;
       public            postgres    false    240    240            !           1259    90139 !   oauth_access_tokens_user_id_index    INDEX     d   CREATE INDEX oauth_access_tokens_user_id_index ON public.oauth_access_tokens USING btree (user_id);
 5   DROP INDEX public.oauth_access_tokens_user_id_index;
       public            postgres    false    243                       1259    90131    oauth_auth_codes_user_id_index    INDEX     ^   CREATE INDEX oauth_auth_codes_user_id_index ON public.oauth_auth_codes USING btree (user_id);
 2   DROP INDEX public.oauth_auth_codes_user_id_index;
       public            postgres    false    242            '           1259    90155    oauth_clients_user_id_index    INDEX     X   CREATE INDEX oauth_clients_user_id_index ON public.oauth_clients USING btree (user_id);
 /   DROP INDEX public.oauth_clients_user_id_index;
       public            postgres    false    246            "           1259    90145 *   oauth_refresh_tokens_access_token_id_index    INDEX     v   CREATE INDEX oauth_refresh_tokens_access_token_id_index ON public.oauth_refresh_tokens USING btree (access_token_id);
 >   DROP INDEX public.oauth_refresh_tokens_access_token_id_index;
       public            postgres    false    244            �           1259    74059 8   personal_access_tokens_tokenable_type_tokenable_id_index    INDEX     �   CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);
 L   DROP INDEX public.personal_access_tokens_tokenable_type_tokenable_id_index;
       public            postgres    false    222    222            =           2606    98354    debt debt_meters_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.debt
    ADD CONSTRAINT debt_meters_id_foreign FOREIGN KEY (meters_id) REFERENCES public.meters(id) ON DELETE CASCADE;
 E   ALTER TABLE ONLY public.debt DROP CONSTRAINT debt_meters_id_foreign;
       public          postgres    false    226    3329    250            >           2606    98384    debts debts_meters_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.debts
    ADD CONSTRAINT debts_meters_id_foreign FOREIGN KEY (meters_id) REFERENCES public.meters(id) ON DELETE CASCADE;
 G   ALTER TABLE ONLY public.debts DROP CONSTRAINT debts_meters_id_foreign;
       public          postgres    false    3329    252    226            ?           2606    106633 #   utility_providers_tariffs fk_tariff    FK CONSTRAINT     �   ALTER TABLE ONLY public.utility_providers_tariffs
    ADD CONSTRAINT fk_tariff FOREIGN KEY (tariff_id) REFERENCES public.tariffs(id) ON DELETE CASCADE;
 M   ALTER TABLE ONLY public.utility_providers_tariffs DROP CONSTRAINT fk_tariff;
       public          postgres    false    228    254    3331            @           2606    106628 &   utility_providers_tariffs fk_util_prov    FK CONSTRAINT     �   ALTER TABLE ONLY public.utility_providers_tariffs
    ADD CONSTRAINT fk_util_prov FOREIGN KEY (utility_provider_id) REFERENCES public.utility_providers(id) ON DELETE CASCADE;
 P   ALTER TABLE ONLY public.utility_providers_tariffs DROP CONSTRAINT fk_util_prov;
       public          postgres    false    254    234    3339            2           2606    98399    users fk_util_prov_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.users
    ADD CONSTRAINT fk_util_prov_id FOREIGN KEY (utility_provider_id) REFERENCES public.utility_providers(id);
 ?   ALTER TABLE ONLY public.users DROP CONSTRAINT fk_util_prov_id;
       public          postgres    false    3339    234    217            4           2606    106586    meters fk_util_provider    FK CONSTRAINT     �   ALTER TABLE ONLY public.meters
    ADD CONSTRAINT fk_util_provider FOREIGN KEY (utility_provider_id) REFERENCES public.utility_providers(id);
 A   ALTER TABLE ONLY public.meters DROP CONSTRAINT fk_util_provider;
       public          postgres    false    3339    226    234            5           2606    74078 "   meters meters_customers_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.meters
    ADD CONSTRAINT meters_customers_id_foreign FOREIGN KEY (customers_id) REFERENCES public.customers(id) ON DELETE CASCADE;
 L   ALTER TABLE ONLY public.meters DROP CONSTRAINT meters_customers_id_foreign;
       public          postgres    false    224    3325    226            9           2606    81958 A   model_has_permissions model_has_permissions_permission_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.model_has_permissions
    ADD CONSTRAINT model_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON DELETE CASCADE;
 k   ALTER TABLE ONLY public.model_has_permissions DROP CONSTRAINT model_has_permissions_permission_id_foreign;
       public          postgres    false    239    236    3343            :           2606    81969 /   model_has_roles model_has_roles_role_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.model_has_roles
    ADD CONSTRAINT model_has_roles_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;
 Y   ALTER TABLE ONLY public.model_has_roles DROP CONSTRAINT model_has_roles_role_id_foreign;
       public          postgres    false    240    3347    238            ;           2606    81979 ?   role_has_permissions role_has_permissions_permission_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON DELETE CASCADE;
 i   ALTER TABLE ONLY public.role_has_permissions DROP CONSTRAINT role_has_permissions_permission_id_foreign;
       public          postgres    false    236    241    3343            <           2606    81984 9   role_has_permissions role_has_permissions_role_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;
 c   ALTER TABLE ONLY public.role_has_permissions DROP CONSTRAINT role_has_permissions_role_id_foreign;
       public          postgres    false    238    3347    241            6           2606    74101 *   token_manage token_manage_meter_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.token_manage
    ADD CONSTRAINT token_manage_meter_id_foreign FOREIGN KEY (meter_id) REFERENCES public.meters(id) ON DELETE CASCADE;
 T   ALTER TABLE ONLY public.token_manage DROP CONSTRAINT token_manage_meter_id_foreign;
       public          postgres    false    226    3329    230            7           2606    74106 +   token_manage token_manage_tariff_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.token_manage
    ADD CONSTRAINT token_manage_tariff_id_foreign FOREIGN KEY (tariff_id) REFERENCES public.tariffs(id) ON DELETE CASCADE;
 U   ALTER TABLE ONLY public.token_manage DROP CONSTRAINT token_manage_tariff_id_foreign;
       public          postgres    false    228    230    3331            3           2606    98389 '   users users_utility_provider_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_utility_provider_id_foreign FOREIGN KEY (utility_provider_model_id) REFERENCES public.utility_providers(id) ON DELETE CASCADE;
 Q   ALTER TABLE ONLY public.users DROP CONSTRAINT users_utility_provider_id_foreign;
       public          postgres    false    3339    234    217            8           2606    74131 B   utility_providers utility_providers_provider_categories_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.utility_providers
    ADD CONSTRAINT utility_providers_provider_categories_id_foreign FOREIGN KEY (provider_categories_id) REFERENCES public.provider_categories(id) ON DELETE CASCADE;
 l   ALTER TABLE ONLY public.utility_providers DROP CONSTRAINT utility_providers_provider_categories_id_foreign;
       public          postgres    false    232    234    3337            �   �   x��=�0@�_q?�H�|����"�A�\:�k !���8����-�,_���(?���f���8P�kF� ����j��َ��{5�-�I��pɨ=\��A��?:;���+o�\h����Y�uB���$�      �      x������ � �      �   R   x�32�44�30�45 #7��47�*S�2Q��<�8�ML!r�ƜFFƺ���F
�&V��V��1c������!W� 	-+      �      x������ � �      �   F   x�M�+�0@��0�o��{�Oz��r2\QM-,7-а���/��ŗ4[(�s��e��t0�<~=      �   �  x�m�ێ� �����P<��&��aƖ	л鷟R�A�� 1�>��~�� PL��QC�:Y��6D��u� l���1����`�M*�/;�/b�h��� ��M֨O-����p�u�?�I�a�1օ$��+�T�r���e���uĚ���b���dCޯ=�H��K:�qTw=��BW	��'][����3��Q���63��͇g��VV��Gr�K�bg	��l$(mL!�3�d5s`Yct:�|7�����y��Xg�୮e����>Ժ��WN@�$VIoƍ�<y��;b"?Nbs�Q&g�3ړ!�F�z��M�x�����F�����>��s�"+A�\����!����������u�*��Tc�i���Vd��"�Þd$oߑ�9^5p���%~o\�m�m�KGT�/v�ɍ?���h��?��ˁ�[      �      x������ � �      �   Y   x�m�!�0DQ�=a'������#���O���O��(�cD\o�ό�g�R1�fˠ�3gl8��rD��Vf�Iq[3��T�J\-3�+t�      �      x������ � �      �      x������ � �      �      x������ � �      �   �   x����n�0е���8@;���@��#ɲI�%U����X X���bt�Ov2��l��KU�5RS��
���2H��ź�J�ˌ{�1k�I�x�x�U��q(���*Oa��m.ui	��θ�aA�s���{!�?�~Ñ ߶>�I-^5 ��Mb�LWn�*�0�gY��q$
��S��3\�܃�ҳ�]�q�_�S�      �   &   x�3�4�4202�5��52R0��22�2�*����� ٫�      �      x������ � �      �      x������ � �      �   �   x����� ��kx
_���Y�1=�e�ׯ�V^x�e�v�C2;���ƍl�3*e
y"U��J�3�5�IRy���M�޵�#qb�vx�-�36����[����Љ(+}���:�R�fr�p�Kރe���{8N_\\;g�{�g�����5�KDy�P���B�z-s�G6��W.=$����	�ÈJ��ghޮ���Ziz�^izt�������S�      �      x������ � �      �   `   x�3�O,I-��t��2426�2�tO,�t����2�t�IM.)�L�,��t5775���2�������44����,H,���K�p41�0������ 	�X      �   N   x�%���@�K1��H/鿎x�ǌ�!{ۑ���h��j
�a�Yf�cn����ї� ���S�+��b_�\�"!y      �   l   x�3�tL����,OM�4202�5��52S04�2��2��&�e�YZ���YR�PP�_���Z��nh�k`�``nebieb�M��b��KjAiI%�V�-fVFFV���ĸb���� ��(�      �      x���tsbSKcKNSNc�=... =�C      �      x������ � �      �   �   x�5ͻ�0 ��}
憂��iD�$��(K��\�ӋF�?9g�(X$�,'ve�y�JQ\�Q�%E{)XU��ݹy��9m=��eBڇ�5��e8l�����͛��V/A�A��Yށ�;hT�Y!��gqB�T����T�6]eȫ�b6Xu�M�!�~|l��v���.ֶP3" �c0B�7��?�      �   s   x�M˻
�0��?#'���14.l�����J���;:|�E�����d�p�������CП���۪�%#�aP��pUh��H��ﻈ�,�Mi��(�N8<��뎈V��#�      �      x�3�4�������� ��     