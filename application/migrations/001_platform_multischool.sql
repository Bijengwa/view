-- EduView platform and school tenancy additions for twinsesp_edu(v2).
-- Run once after importing twinsesp_edu(v2).sql.

ALTER TABLE `school_profiles`
    ADD COLUMN `slug` varchar(120) DEFAULT NULL AFTER `name`;
ALTER TABLE `school_profiles`
    ADD COLUMN `subdomain` varchar(120) DEFAULT NULL AFTER `slug`;

UPDATE `school_profiles` SET `slug` = CASE `id`
    WHEN 1 THEN 'twinses-pride-schools'
    WHEN 2 THEN 'musabe-schools'
    WHEN 3 THEN 'kaizirege'
    WHEN 4 THEN 'feza-schools'
    WHEN 5 THEN 'dynamic-schools'
    WHEN 6 THEN 'marian-schools'
    ELSE NULL
END
WHERE `slug` IS NULL;

UPDATE `school_profiles` SET `subdomain` = `slug` WHERE `subdomain` IS NULL;

-- The v2 dump already maps its existing branches. Review any NULL rows before
-- running this statement on a legacy database; do not assign them blindly.
ALTER TABLE `branch`
    MODIFY COLUMN `school_profile_id` int(11) NOT NULL;

ALTER TABLE `school_profiles`
    ADD UNIQUE KEY `school_profiles_slug_unique` (`slug`);
ALTER TABLE `school_profiles`
    ADD UNIQUE KEY `school_profiles_subdomain_unique` (`subdomain`);

CREATE TABLE `school_profile_admins` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `school_profile_id` int(11) NOT NULL,
    `staff_id` int(11) NOT NULL,
    `is_primary` tinyint(1) NOT NULL DEFAULT 1,
    `status` tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `school_profile_admin_primary` (`school_profile_id`, `staff_id`),
    KEY `school_profile_admin_staff_idx` (`staff_id`),
    CONSTRAINT `fk_school_profile_admin_school` FOREIGN KEY (`school_profile_id`) REFERENCES `school_profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_school_profile_admin_staff` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `eduview_platform_admins` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `staff_id` int(11) NOT NULL,
    `status` tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `eduview_platform_admin_staff_unique` (`staff_id`),
    CONSTRAINT `fk_eduview_platform_admin_staff` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT IGNORE INTO `eduview_platform_admins` (`staff_id`)
SELECT `user_id`
FROM `login_credential`
WHERE `role` = 1 AND `user_id` = 1;
