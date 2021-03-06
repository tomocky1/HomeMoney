
/* Drop Tables */

DROP TABLE IF EXISTS trans;
DROP TABLE IF EXISTS incomes;
DROP TABLE IF EXISTS outgoings;
DROP TABLE IF EXISTS accounts;
DROP TABLE IF EXISTS balances;
DROP TABLE IF EXISTS date_numbering;
DROP TABLE IF EXISTS moves;
DROP TABLE IF EXISTS payments;
DROP TABLE IF EXISTS receipts;
DROP TABLE IF EXISTS USERS;
DROP TABLE IF EXISTS wallets;




/* Create Tables */

-- 勘定科目
CREATE TABLE accounts
(
	-- ID
	id bigserial NOT NULL,
	-- 勘定科目名称
	name varchar NOT NULL,
	-- 表示順
	dorder int NOT NULL,
	-- 有効フラグ
	enable_flag boolean NOT NULL,
	-- SYS登録日時
	sys_created_at timestamp NOT NULL,
	-- SYS更新日時
	sys_updated_at timestamp NOT NULL,
	-- SYS削除日時
	sys_deleted_at timestamp,
	-- SYS削除フラグ
	sys_deleted_flag boolean DEFAULT 'FALSE' NOT NULL,
	-- VERSION
	version bigint DEFAULT 1 NOT NULL,
	PRIMARY KEY (id)
) WITHOUT OIDS;


-- 残高
CREATE TABLE balances
(
	-- id
	id bigserial NOT NULL,
	-- 財布ID
	wallet_id bigserial NOT NULL UNIQUE,
	-- 残高
	balance bigint NOT NULL,
	-- 更新日時
	update_tsp timestamp NOT NULL,
	-- SYS登録日時
	sys_created_at timestamp NOT NULL,
	-- SYS更新日時
	sys_updated_at timestamp NOT NULL,
	-- SYS削除日時
	sys_deleted_at timestamp,
	-- SYS削除フラグ
	sys_deleted_flag boolean DEFAULT 'FALSE' NOT NULL,
	-- VERSION
	version bigint DEFAULT 1 NOT NULL,
	PRIMARY KEY (id)
) WITHOUT OIDS;


-- 日別採番
CREATE TABLE date_numbering
(
	-- ID
	id bigserial NOT NULL,
	-- 採番種別 : 種別
	-- 0001：収入番号
	-- 0002：支出番号
	-- 0003：移動番号
	clazz char(4) NOT NULL,
	-- 日付
	ymd date NOT NULL,
	-- 採番値
	val int,
	-- SYS登録日時
	sys_created_at timestamp NOT NULL,
	-- SYS更新日時
	sys_updated_at timestamp NOT NULL,
	-- SYS削除日時
	sys_deleted_at timestamp,
	-- SYS削除フラグ
	sys_deleted_flag boolean DEFAULT 'FALSE' NOT NULL,
	-- VERSION
	version bigint DEFAULT 1 NOT NULL,
	PRIMARY KEY (id)
) WITHOUT OIDS;


-- 収入
CREATE TABLE incomes
(
	-- ID
	id bigserial NOT NULL,
	-- 勘定科目ID
	account_id bigint NOT NULL,
	-- 受取方法ID
	receipt_id bigint NOT NULL,
	-- 収入番号 : 収入毎に割り振る番号.YYYYMMDDnnn形式とし、YYYYMMDDは取引日の文字列表現、nnnは取引日毎の連番
	income_no char(11) NOT NULL UNIQUE,
	-- 摘要 : 収入の摘要を記載
	summery varchar,
	-- 金額
	amount bigint NOT NULL,
	-- 取引日
	trade_date date NOT NULL,
	-- 決済日
	settle_date date NOT NULL,
	-- 登録日時
	regist_tsp timestamp NOT NULL,
	-- 削除フラグ
	delete_flag boolean DEFAULT 'FALSE' NOT NULL,
	-- 修正フラグ
	modify_flag boolean DEFAULT 'FALSE' NOT NULL,
	-- 修正前ID
	id_bfr bigint,
	-- 変更済区分 : N:未修正、M:修正済、D:削除済
	-- 修正・削除を実行した場合の修正元レコードに設定する。
	updated_flag char(1) DEFAULT 'N' NOT NULL,
	-- 有効フラグ
	active_flag boolean DEFAULT 'TRUE' NOT NULL,
	-- SYS登録日時
	sys_created_at timestamp NOT NULL,
	-- SYS更新日時
	sys_updated_at timestamp NOT NULL,
	-- SYS削除日時
	sys_deleted_at timestamp,
	-- SYS削除フラグ
	sys_deleted_flag boolean DEFAULT 'FALSE' NOT NULL,
	-- VERSION
	version bigint DEFAULT 1 NOT NULL,
	PRIMARY KEY (id),
	CONSTRAINT UNIQUE_INCOMES_INCOMENO_TRADEDATE UNIQUE (income_no, trade_date)
) WITHOUT OIDS;


-- 移動
CREATE TABLE moves
(
	-- ID
	id bigserial NOT NULL,
	-- 移動元財布ID
	src_wallet_id bigint NOT NULL,
	-- 移動先財布ID
	dist_wallet_id bigint NOT NULL,
	-- 移動番号
	move_no char(12) NOT NULL,
	-- 摘要
	summery varchar,
	-- 金額
	amount bigint NOT NULL,
	-- 取引日
	trade_date date NOT NULL,
	-- 決済日
	settle_date date NOT NULL,
	-- 登録日時
	regist_tsp timestamp NOT NULL,
	-- 削除フラグ
	delete_flag boolean DEFAULT 'FALSE' NOT NULL,
	-- 修正フラグ
	modify_flag boolean DEFAULT 'FALSE' NOT NULL,
	-- 修正前ID
	id_bfr bigint,
	-- 変更済区分 : N:未修正、M:修正済、D:削除済
	-- 修正・削除を実行した場合の修正元レコードに設定する。
	updated_flag char(1) DEFAULT 'N' NOT NULL,
	-- 有効フラグ
	active_flag boolean DEFAULT 'TRUE' NOT NULL,
	-- SYS登録日時
	sys_created_at timestamp NOT NULL,
	-- SYS更新日時
	sys_updated_at timestamp NOT NULL,
	-- SYS削除日時
	sys_deleted_at timestamp,
	-- SYS削除フラグ
	sys_deleted_flag boolean DEFAULT 'FALSE' NOT NULL,
	-- VERSION
	version bigint DEFAULT 1 NOT NULL,
	PRIMARY KEY (id),
	CONSTRAINT UNIQUE_MOVES_MOVENO_TRADEDATE UNIQUE (move_no, trade_date)
) WITHOUT OIDS;


-- 支出
CREATE TABLE outgoings
(
	-- ID
	id bigserial NOT NULL,
	-- 勘定科目ID
	account_id bigint NOT NULL,
	-- 支払方法ID
	payment_id bigint NOT NULL,
	-- 支出番号
	outgoing_no char(11) NOT NULL UNIQUE,
	-- 摘要
	summery varchar,
	-- 金額
	amount bigint NOT NULL,
	-- 取引日
	trade_date date NOT NULL,
	-- 決済日
	settle_date date,
	-- 登録日時
	regist_tsp timestamp NOT NULL,
	-- 削除フラグ
	delete_flag boolean DEFAULT 'FALSE' NOT NULL,
	-- 修正フラグ
	modify_flag boolean DEFAULT 'FALSE' NOT NULL,
	-- 修正前ID
	id_bfr bigint,
	-- 変更済区分 : N:未修正、M:修正済、D:削除済
	-- 修正・削除を実行した場合の修正元レコードに設定する。
	updated_flag char(1) DEFAULT 'N' NOT NULL,
	-- 有効フラグ
	active_flag boolean DEFAULT 'TRUE' NOT NULL,
	-- SYS登録日時
	sys_created_at timestamp NOT NULL,
	-- SYS更新日時
	sys_updated_at timestamp NOT NULL,
	-- SYS削除日時
	sys_deleted_at timestamp,
	-- SYS削除フラグ
	sys_deleted_flag boolean DEFAULT 'FALSE' NOT NULL,
	-- VERSION
	version bigint DEFAULT 1 NOT NULL,
	PRIMARY KEY (id),
	CONSTRAINT UNIQUE_OUTGOINGS_OUTGOINGNO_TRADEDATE UNIQUE (outgoing_no, trade_date)
) WITHOUT OIDS;


-- 支払方法
CREATE TABLE payments
(
	-- ID
	id bigserial NOT NULL,
	-- 財布ID
	wallet_id bigint NOT NULL,
	-- 支払い方法名称
	name varchar,
	-- 表示順
	dorder int NOT NULL,
	-- 有効フラグ
	enable_flag boolean NOT NULL,
	-- SYS登録日時
	sys_created_at timestamp NOT NULL,
	-- SYS更新日時
	sys_updated_at timestamp NOT NULL,
	-- SYS削除日時
	sys_deleted_at timestamp,
	-- SYS削除フラグ
	sys_deleted_flag boolean DEFAULT 'FALSE' NOT NULL,
	-- VERSION
	version bigint DEFAULT 1 NOT NULL,
	PRIMARY KEY (id)
) WITHOUT OIDS;


-- 受取方法
CREATE TABLE receipts
(
	-- ID
	id bigserial NOT NULL,
	-- 財布ID
	wallet_id bigint NOT NULL,
	-- 受取方法名称
	name varchar,
	-- 表示順
	dorder int NOT NULL,
	-- 有効フラグ
	enable_flag boolean,
	-- SYS登録日時
	sys_created_at timestamp NOT NULL,
	-- SYS更新日時
	sys_updated_at timestamp NOT NULL,
	-- SYS削除日時
	sys_deleted_at timestamp,
	-- SYS削除フラグ
	sys_deleted_flag boolean DEFAULT 'FALSE' NOT NULL,
	-- VERSION
	version bigint DEFAULT 1 NOT NULL,
	PRIMARY KEY (id)
) WITHOUT OIDS;


-- 受払
CREATE TABLE trans
(
	-- ID
	id bigserial NOT NULL,
	-- 収入ID
	income_id bigint,
	-- 支出ID
	outgoing_id bigint,
	-- 移動ID
	move_id bigint,
	-- 財布ID
	wallet_id bigint NOT NULL,
	-- 勘定科目ID
	account_id bigint,
	-- 金額
	amount bigint DEFAULT 0 NOT NULL,
	-- 増減
	up_down bigint NOT NULL,
	-- 決済日
	settle_date date NOT NULL,
	-- SYS登録日時
	sys_created_at timestamp NOT NULL,
	-- SYS更新日時
	sys_updated_at timestamp NOT NULL,
	-- SYS削除日時
	sys_deleted_at timestamp,
	-- SYS削除フラグ
	sys_deleted_flag boolean DEFAULT 'FALSE' NOT NULL,
	-- VERSION
	version bigint DEFAULT 1 NOT NULL,
	PRIMARY KEY (id)
) WITHOUT OIDS;


-- ユーザ
CREATE TABLE USERS
(
	-- ID
	id serial NOT NULL,
	-- ユーザ名
	name varchar NOT NULL,
	-- メールアドレス
	email varchar NOT NULL,
	-- パスワード
	password varchar NOT NULL,
	-- トークン
	remember_token varchar(100),
	-- APIトークン
	api_token varchar(60),
	-- 作成日時
	created_at timestamp,
	-- 更新日時
	updated_at timestamp,
	PRIMARY KEY (id)
) WITHOUT OIDS;


-- 財布
CREATE TABLE wallets
(
	-- ID
	id bigserial NOT NULL,
	-- 財布名称
	name varchar NOT NULL,
	-- 表示順
	dorder int NOT NULL,
	-- 有効フラグ
	enable_flag boolean NOT NULL,
	-- SYS登録日時
	sys_created_at timestamp NOT NULL,
	-- SYS更新日時
	sys_updated_at timestamp NOT NULL,
	-- SYS削除日時
	sys_deleted_at timestamp,
	-- SYS削除フラグ
	sys_deleted_flag boolean DEFAULT 'FALSE' NOT NULL,
	-- VERSION
	version bigint DEFAULT 1 NOT NULL,
	PRIMARY KEY (id)
) WITHOUT OIDS;



/* Create Foreign Keys */

ALTER TABLE incomes
	ADD FOREIGN KEY (account_id)
	REFERENCES accounts (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE outgoings
	ADD FOREIGN KEY (account_id)
	REFERENCES accounts (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE trans
	ADD FOREIGN KEY (income_id)
	REFERENCES incomes (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE trans
	ADD FOREIGN KEY (move_id)
	REFERENCES moves (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE trans
	ADD FOREIGN KEY (outgoing_id)
	REFERENCES outgoings (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE outgoings
	ADD FOREIGN KEY (payment_id)
	REFERENCES payments (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE incomes
	ADD FOREIGN KEY (receipt_id)
	REFERENCES receipts (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE moves
	ADD FOREIGN KEY (src_wallet_id)
	REFERENCES wallets (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE moves
	ADD FOREIGN KEY (dist_wallet_id)
	REFERENCES wallets (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE payments
	ADD FOREIGN KEY (wallet_id)
	REFERENCES wallets (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE receipts
	ADD FOREIGN KEY (wallet_id)
	REFERENCES wallets (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;



/* Comments */

COMMENT ON TABLE accounts IS '勘定科目';
COMMENT ON COLUMN accounts.id IS 'ID';
COMMENT ON COLUMN accounts.name IS '勘定科目名称';
COMMENT ON COLUMN accounts.dorder IS '表示順';
COMMENT ON COLUMN accounts.enable_flag IS '有効フラグ';
COMMENT ON COLUMN accounts.sys_created_at IS 'SYS登録日時';
COMMENT ON COLUMN accounts.sys_updated_at IS 'SYS更新日時';
COMMENT ON COLUMN accounts.sys_deleted_at IS 'SYS削除日時';
COMMENT ON COLUMN accounts.sys_deleted_flag IS 'SYS削除フラグ';
COMMENT ON COLUMN accounts.version IS 'VERSION';
COMMENT ON TABLE balances IS '残高';
COMMENT ON COLUMN balances.id IS 'id';
COMMENT ON COLUMN balances.wallet_id IS '財布ID';
COMMENT ON COLUMN balances.balance IS '残高';
COMMENT ON COLUMN balances.update_tsp IS '更新日時';
COMMENT ON COLUMN balances.sys_created_at IS 'SYS登録日時';
COMMENT ON COLUMN balances.sys_updated_at IS 'SYS更新日時';
COMMENT ON COLUMN balances.sys_deleted_at IS 'SYS削除日時';
COMMENT ON COLUMN balances.sys_deleted_flag IS 'SYS削除フラグ';
COMMENT ON COLUMN balances.version IS 'VERSION';
COMMENT ON TABLE date_numbering IS '日別採番';
COMMENT ON COLUMN date_numbering.id IS 'ID';
COMMENT ON COLUMN date_numbering.clazz IS '採番種別 : 種別
0001：収入番号
0002：支出番号
0003：移動番号';
COMMENT ON COLUMN date_numbering.ymd IS '日付';
COMMENT ON COLUMN date_numbering.val IS '採番値';
COMMENT ON COLUMN date_numbering.sys_created_at IS 'SYS登録日時';
COMMENT ON COLUMN date_numbering.sys_updated_at IS 'SYS更新日時';
COMMENT ON COLUMN date_numbering.sys_deleted_at IS 'SYS削除日時';
COMMENT ON COLUMN date_numbering.sys_deleted_flag IS 'SYS削除フラグ';
COMMENT ON COLUMN date_numbering.version IS 'VERSION';
COMMENT ON TABLE incomes IS '収入';
COMMENT ON COLUMN incomes.id IS 'ID';
COMMENT ON COLUMN incomes.account_id IS '勘定科目ID';
COMMENT ON COLUMN incomes.receipt_id IS '受取方法ID';
COMMENT ON COLUMN incomes.income_no IS '収入番号 : 収入毎に割り振る番号.YYYYMMDDnnn形式とし、YYYYMMDDは取引日の文字列表現、nnnは取引日毎の連番';
COMMENT ON COLUMN incomes.summery IS '摘要 : 収入の摘要を記載';
COMMENT ON COLUMN incomes.amount IS '金額';
COMMENT ON COLUMN incomes.trade_date IS '取引日';
COMMENT ON COLUMN incomes.settle_date IS '決済日';
COMMENT ON COLUMN incomes.regist_tsp IS '登録日時';
COMMENT ON COLUMN incomes.delete_flag IS '削除フラグ';
COMMENT ON COLUMN incomes.modify_flag IS '修正フラグ';
COMMENT ON COLUMN incomes.id_bfr IS '修正前ID';
COMMENT ON COLUMN incomes.updated_flag IS '変更済区分 : N:未修正、M:修正済、D:削除済
修正・削除を実行した場合の修正元レコードに設定する。';
COMMENT ON COLUMN incomes.active_flag IS '有効フラグ';
COMMENT ON COLUMN incomes.sys_created_at IS 'SYS登録日時';
COMMENT ON COLUMN incomes.sys_updated_at IS 'SYS更新日時';
COMMENT ON COLUMN incomes.sys_deleted_at IS 'SYS削除日時';
COMMENT ON COLUMN incomes.sys_deleted_flag IS 'SYS削除フラグ';
COMMENT ON COLUMN incomes.version IS 'VERSION';
COMMENT ON TABLE moves IS '移動';
COMMENT ON COLUMN moves.id IS 'ID';
COMMENT ON COLUMN moves.src_wallet_id IS '移動元財布ID';
COMMENT ON COLUMN moves.dist_wallet_id IS '移動先財布ID';
COMMENT ON COLUMN moves.move_no IS '移動番号';
COMMENT ON COLUMN moves.summery IS '摘要';
COMMENT ON COLUMN moves.amount IS '金額';
COMMENT ON COLUMN moves.trade_date IS '取引日';
COMMENT ON COLUMN moves.settle_date IS '決済日';
COMMENT ON COLUMN moves.regist_tsp IS '登録日時';
COMMENT ON COLUMN moves.delete_flag IS '削除フラグ';
COMMENT ON COLUMN moves.modify_flag IS '修正フラグ';
COMMENT ON COLUMN moves.id_bfr IS '修正前ID';
COMMENT ON COLUMN moves.updated_flag IS '変更済区分 : N:未修正、M:修正済、D:削除済
修正・削除を実行した場合の修正元レコードに設定する。';
COMMENT ON COLUMN moves.active_flag IS '有効フラグ';
COMMENT ON COLUMN moves.sys_created_at IS 'SYS登録日時';
COMMENT ON COLUMN moves.sys_updated_at IS 'SYS更新日時';
COMMENT ON COLUMN moves.sys_deleted_at IS 'SYS削除日時';
COMMENT ON COLUMN moves.sys_deleted_flag IS 'SYS削除フラグ';
COMMENT ON COLUMN moves.version IS 'VERSION';
COMMENT ON TABLE outgoings IS '支出';
COMMENT ON COLUMN outgoings.id IS 'ID';
COMMENT ON COLUMN outgoings.account_id IS '勘定科目ID';
COMMENT ON COLUMN outgoings.payment_id IS '支払方法ID';
COMMENT ON COLUMN outgoings.outgoing_no IS '支出番号';
COMMENT ON COLUMN outgoings.summery IS '摘要';
COMMENT ON COLUMN outgoings.amount IS '金額';
COMMENT ON COLUMN outgoings.trade_date IS '取引日';
COMMENT ON COLUMN outgoings.settle_date IS '決済日';
COMMENT ON COLUMN outgoings.regist_tsp IS '登録日時';
COMMENT ON COLUMN outgoings.delete_flag IS '削除フラグ';
COMMENT ON COLUMN outgoings.modify_flag IS '修正フラグ';
COMMENT ON COLUMN outgoings.id_bfr IS '修正前ID';
COMMENT ON COLUMN outgoings.updated_flag IS '変更済区分 : N:未修正、M:修正済、D:削除済
修正・削除を実行した場合の修正元レコードに設定する。';
COMMENT ON COLUMN outgoings.active_flag IS '有効フラグ';
COMMENT ON COLUMN outgoings.sys_created_at IS 'SYS登録日時';
COMMENT ON COLUMN outgoings.sys_updated_at IS 'SYS更新日時';
COMMENT ON COLUMN outgoings.sys_deleted_at IS 'SYS削除日時';
COMMENT ON COLUMN outgoings.sys_deleted_flag IS 'SYS削除フラグ';
COMMENT ON COLUMN outgoings.version IS 'VERSION';
COMMENT ON TABLE payments IS '支払方法';
COMMENT ON COLUMN payments.id IS 'ID';
COMMENT ON COLUMN payments.wallet_id IS '財布ID';
COMMENT ON COLUMN payments.name IS '支払い方法名称';
COMMENT ON COLUMN payments.dorder IS '表示順';
COMMENT ON COLUMN payments.enable_flag IS '有効フラグ';
COMMENT ON COLUMN payments.sys_created_at IS 'SYS登録日時';
COMMENT ON COLUMN payments.sys_updated_at IS 'SYS更新日時';
COMMENT ON COLUMN payments.sys_deleted_at IS 'SYS削除日時';
COMMENT ON COLUMN payments.sys_deleted_flag IS 'SYS削除フラグ';
COMMENT ON COLUMN payments.version IS 'VERSION';
COMMENT ON TABLE receipts IS '受取方法';
COMMENT ON COLUMN receipts.id IS 'ID';
COMMENT ON COLUMN receipts.wallet_id IS '財布ID';
COMMENT ON COLUMN receipts.name IS '受取方法名称';
COMMENT ON COLUMN receipts.dorder IS '表示順';
COMMENT ON COLUMN receipts.enable_flag IS '有効フラグ';
COMMENT ON COLUMN receipts.sys_created_at IS 'SYS登録日時';
COMMENT ON COLUMN receipts.sys_updated_at IS 'SYS更新日時';
COMMENT ON COLUMN receipts.sys_deleted_at IS 'SYS削除日時';
COMMENT ON COLUMN receipts.sys_deleted_flag IS 'SYS削除フラグ';
COMMENT ON COLUMN receipts.version IS 'VERSION';
COMMENT ON TABLE trans IS '受払';
COMMENT ON COLUMN trans.id IS 'ID';
COMMENT ON COLUMN trans.income_id IS '収入ID';
COMMENT ON COLUMN trans.outgoing_id IS '支出ID';
COMMENT ON COLUMN trans.move_id IS '移動ID';
COMMENT ON COLUMN trans.wallet_id IS '財布ID';
COMMENT ON COLUMN trans.account_id IS '勘定科目ID';
COMMENT ON COLUMN trans.amount IS '金額';
COMMENT ON COLUMN trans.up_down IS '増減';
COMMENT ON COLUMN trans.settle_date IS '決済日';
COMMENT ON COLUMN trans.sys_created_at IS 'SYS登録日時';
COMMENT ON COLUMN trans.sys_updated_at IS 'SYS更新日時';
COMMENT ON COLUMN trans.sys_deleted_at IS 'SYS削除日時';
COMMENT ON COLUMN trans.sys_deleted_flag IS 'SYS削除フラグ';
COMMENT ON COLUMN trans.version IS 'VERSION';
COMMENT ON TABLE USERS IS 'ユーザ';
COMMENT ON COLUMN USERS.id IS 'ID';
COMMENT ON COLUMN USERS.name IS 'ユーザ名';
COMMENT ON COLUMN USERS.email IS 'メールアドレス';
COMMENT ON COLUMN USERS.password IS 'パスワード';
COMMENT ON COLUMN USERS.remember_token IS 'トークン';
COMMENT ON COLUMN USERS.api_token IS 'APIトークン';
COMMENT ON COLUMN USERS.created_at IS '作成日時';
COMMENT ON COLUMN USERS.updated_at IS '更新日時';
COMMENT ON TABLE wallets IS '財布';
COMMENT ON COLUMN wallets.id IS 'ID';
COMMENT ON COLUMN wallets.name IS '財布名称';
COMMENT ON COLUMN wallets.dorder IS '表示順';
COMMENT ON COLUMN wallets.enable_flag IS '有効フラグ';
COMMENT ON COLUMN wallets.sys_created_at IS 'SYS登録日時';
COMMENT ON COLUMN wallets.sys_updated_at IS 'SYS更新日時';
COMMENT ON COLUMN wallets.sys_deleted_at IS 'SYS削除日時';
COMMENT ON COLUMN wallets.sys_deleted_flag IS 'SYS削除フラグ';
COMMENT ON COLUMN wallets.version IS 'VERSION';



