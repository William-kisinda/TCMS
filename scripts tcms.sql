select * from customers
select * from meters
select * from permissions
select * from users
select * from debts
select * from utility_providers
select * from tariffs
select * from provider_categories
select * from token_manage
select * from utility_providers_tariffs
select * from partners

DELETE FROM token_manage;


CREATE TABLE IF NOT EXISTS utility_providers_tariffs (
   id SERIAL PRIMARY KEY,
   utility_provider_id bigint,
   tariff_id bigint,
   CONSTRAINT fk_util_prov
   FOREIGN KEY (utility_provider_id)
   REFERENCES utility_providers(id) ON DELETE CASCADE,
   CONSTRAINT fk_tariff
   FOREIGN KEY (tariff_id)
   REFERENCES tariffs(id) ON DELETE CASCADE
);

ALTER TABLE token_manage
ADD COLUMN utility_provider_id BIGINT,
ADD CONSTRAINT fk_util_provider FOREIGN KEY(utility_provider_id) REFERENCES utility_providers(id);

ALTER TABLE token_manage
DROP CONSTRAINT utility_provider_id,
DROP COLUMN utility_provider_id;


DROP TABLE notifications
-- Alter table token_manage
-- rename column meter_id to meters_id


CREATE TABLE partners (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    code VARCHAR(255) NOT NULL
);

Insert into partners(name,code) values('CRDB','CRDB112')


SELECT id FROM permissions
WHERE 
te) = WEEK( current_date ) - 1 AND YEAR( date) = YEAR( current_date );