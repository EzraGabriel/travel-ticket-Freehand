-- Jumlah Penumpang
CREATE TRIGGER kursi_penumpang ON tiket AFTER INSERT
AS
BEGIN
	declare @id_tiket int  
	declare @id_transportasi int  
    
    SELECT @id_tiket = id_tiket from inserted  
	SELECT @id_transportasi =  id_transportasi from inserted  

	UPDATE tiket SET sisa_kursi = (SELECT jumlah_kursi FROM transportasi WHERE id_trasportasi = @id_transportasi)
END

-- chek email
CREATE trigger check_email ON [user] INSTEAD OF INSERT
AS
BEGIN
	declare @email VARCHAR(255)
	declare @pass VARCHAR(255)  
	SELECT @email = email from inserted
	IF EXISTS (SELECT email FROM [user] WHERE email=@email)
		BEGIN
			raiserror('Email Exists', 16, 1)
		END;
	ELSE
		SELECT @pass = password from inserted
		INSERT INTO [user](email, password) VALUES(@email, @pass);
END