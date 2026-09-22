# EduView Platform Admin

The application is in the `view` folder. The platform administration door is:

`/eduview-admin/login`

After login:

- `/eduview-admin/dashboard` shows platform totals.
- `/eduview-admin/schools` lists schools and allows activation or suspension.
- `/eduview-admin/schools/create` registers a school and its first School Superadmin in one database transaction.
- `/eduview-admin/schools/view/{id}` displays a school without exposing passwords.
- `/eduview-admin/schools/edit/{id}` updates school metadata and its subdomain.
- `/eduview-admin/school-admins` lists school administrators and their assigned school.

## Database setup

Import `twinsesp_edu(v2).sql`, then run `application/migrations/001_platform_multischool.sql` once. The migration adds school slugs, school-admin mappings, and the platform-admin mapping.

Set `eduview_base_domain` in `application/config/config.php`, for example `eduview.test`. A school registered as `greenvalley` is then served at `greenvalley.eduview.test` when wildcard DNS/web-server routing is configured.