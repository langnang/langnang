SELECT
    count(*)
FROM
    typecho_nav_contents
    LEFT JOIN (
	SELECT
        cid,
        group_concat( CASE name WHEN 'url' THEN str_value ELSE NULL END ) AS url,
        group_concat( CASE name WHEN 'text' THEN str_value ELSE NULL END ) AS text,
        group_concat( CASE name WHEN 'logo' THEN str_value ELSE NULL END ) AS logo
    FROM
        typecho_nav_fields
    GROUP BY
		cid
	) AS T ON ( typecho_nav_contents.cid = T.cid )
    LEFT JOIN (
	SELECT
        cid,
        group_concat( CASE type WHEN 'category' THEN NAME ELSE NULL END ) category,
        group_concat( CASE type WHEN 'tag' THEN NAME ELSE NULL END ) tag
    FROM
        typecho_nav_relationships,
        typecho_nav_metas
    WHERE
		typecho_nav_relationships.mid = typecho_nav_metas.mid
    GROUP BY
		cid
	) AS M ON ( typecho_nav_contents.cid = M.cid )
WHERE
    IFNULL( category, '') LIKE CONCAT('%', ?, '%')
    AND IFNULL( tag, '' ) LIKE CONCAT('%', ?, '%')
