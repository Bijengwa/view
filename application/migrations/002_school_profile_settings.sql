-- School-level settings moved from branch to school_profiles.
-- Run once after 001_platform_multischool.sql.

ALTER TABLE `school_profiles`
    ADD COLUMN `currency` varchar(100) NOT NULL DEFAULT 'Tzs' AFTER `address`,
    ADD COLUMN `currency_symbol` varchar(25) NOT NULL DEFAULT 'TZS' AFTER `currency`,
    ADD COLUMN `timezone` varchar(100) NOT NULL DEFAULT 'Africa/Dar_es_Salaam' AFTER `currency_symbol`;

-- Copy currency/timezone from each school's first branch.
UPDATE `school_profiles` sp
JOIN (
    SELECT b.school_profile_id, b.currency, b.symbol, b.timezone
    FROM `branch` b
    JOIN (SELECT school_profile_id, MIN(id) AS first_id FROM `branch` GROUP BY school_profile_id) f
      ON f.first_id = b.id
) fb ON fb.school_profile_id = sp.id
SET sp.currency = IF(fb.currency <> '', fb.currency, sp.currency),
    sp.currency_symbol = IF(fb.symbol <> '', fb.symbol, sp.currency_symbol),
    sp.timezone = IF(fb.timezone <> '', fb.timezone, sp.timezone);
