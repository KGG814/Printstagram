-- Finding groups owned by a particular person
SELECT gname
FROM friendGroup
WHERE ownername = ?

-- Finding the friends in a particular group
SELECT username
FROM inGroup
WHERE gname = ? AND ownername = ?

-- Remove a person from the group
DELETE FROM inGroup
WHERE ownername = ? AND gname = ? AND username = ?

-- Add a person into the group
INSERT INTO inGroup (ownername, gname, username)
VALUES (?, ?, ?)

-- Add a a new group
INSERT INTO friendGroup (gname, descr, ownername)
VALUES (?, ?, ?)

-- Find all usernames corresponsing to a first and last name
SELECT username
FROM person
WHERE fname = ? AND lname = ?

-- Find all photos shared with a particular user, as well as all
-- public photos not owned by user
(SELECT pid, poster, pdate, caption, image
FROM photo NATURAL JOIN shared NATURAL JOIN inGroup
WHERE username = ? AND poster != ?)
UNION
(SELECT pid, poster, pdate, caption, image
FROM photo
WHERE is_pub = 1 AND poster != ?)
ORDER BY pdate DESC

-- Get login data
SELECT username, password 
FROM person 
WHERE username = ? and password = ?

-- Find the pid of the last photo
SELECT MAX(pid) FROM photo

-- Add a new photo
INSERT INTO photo (pid, poster, caption, pdate, lnge, lat, lname, is_pub) VALUES (?, ?, ?, FROM_UNIXTIME(?), 0, 0, \"location\", ?)

-- Get permission to move files
GRANT FILE ON *.* TO 'root'@'localhost'

-- Set photo to have image
UPDATE photo SET image = \"YES\" WHERE pid = ?

-- Set photo to not have image
UPDATE photo SET image = \"NO\" WHERE pid = ?

-- Get all unapproved tags of a particular person
SELECT tagger, ttime, pid
FROM tag
WHERE taggee = ? AND tstatus = 0

-- Approve a tag
UPDATE tag
SET tstatus = 1
WHERE pid = ? AND taggee = ? AND tagger = ?

-- Remove a tag
DELETE FROM tag
WHERE pid = ? AND taggee = ? AND tagger = ?

-- Get a comment
SELECT username, ctext, ctime
FROM comment NATURAL JOIN commentOn
WHERE pid = ?
ORDER BY ctime ASC

-- Get an approved tag
SELECT tagger, ttime, taggee
FROM tag
WHERE pid = ? AND tstatus = 1

-- Check that the user has permission to view photo
SELECT *
FROM ((SELECT pid
FROM photo NATURAL JOIN shared NATURAL JOIN inGroup
WHERE username = ?)
UNION
(SELECT pid
FROM photo
WHERE poster = ? OR is_pub = 1)) as T
WHERE pid = ?

-- Get a photo
SELECT poster, image, is_pub, caption
FROM photo
WHERE pid = ?

-- Get all groups of a particular user
SELECT gname
FROM friendGroup
WHERE ownername = ?

-- Share a photo with a group
INSERT INTO shared (pid, gname, ownername)
VALUES (?, ?, ?)

-- Get all usernames
SELECT username
FROM person

-- Add a tag
INSERT INTO tag (pid, tagger, taggee, ttime, tstatus)
VALUES (?, ?, ?, FROM_UNIXTIME(?), ?)

-- Get all images of user
SELECT pid, image
FROM photo
WHERE poster = ?
ORDER BY pdate DESC
