import platform
class Config:
    @staticmethod
    def connection_info():
        if platform.system() == "Windows":
            return {
                "host":"localhost",
                "user":"root",
                "password":"",
                "database":"documind"
            }
        else:
            return {
                "host":"db5018917755.hosting-data.io",
                "user":"dbu3738302",
                "password":"78Agracian#J(L",
                "database":"dbs14916465"
            } 

