<?php


class Kkrieger_SecurityTxt_Model_SecurityTxtFile
{
    const XML_CONFIG_PATH_SUFFIX = 'security/txt/';
    const XML_CONFIG_CONTACT_FALLBACK = 'contacts/email/recipient_email';

    const FILENAME = 'security.txt';

    private $entries = [
        'contact' => '',
        'encryption' => '',
        'acknowledgments' => '',
        'preferredLanguage' => '',
        'canonical' => '',
        'policy' => '',
        'hiring' => ''
    ];


    /**
     * create security.txt file
     * @return bool|null
     */
    public function create(): ?bool
    {
        $this->collectData();
        return $this->generateOrUpdateFile();
    }

    /**
     * Get all config values
     * @return $this|null
     */
    private function collectData(): ?self
    {
        foreach ($this->entries as $identifier => $value) {
            $config = $this->getConfig($identifier);
            if ($config != '') {
                $this->entries[$identifier] = $config;
            } else {
                unset($this->entries[$identifier]);
            }
        }

        return $this;
    }

    /**
     * RFC recommends to put the file in /.well-known/security.txt or /security.txt (root directory)
     * @return bool|null
     */
    private function generateOrUpdateFile($path = '.well-known'): ?bool
    {
        try {
            $baseDir = Mage::getBaseDir('base');
            $filePath = empty($path) ? $baseDir : $baseDir . DS . $path;

            $this->_createWriteableDir($filePath);

            $ioFile = new Varien_Io_File();
            $fileName = $ioFile->getCleanPath($filePath . DS . self::FILENAME);
            $ioFile->open(array('path' => $filePath));

            $ioFile->rm($fileName);

            $ioFile->cd($filePath);
            if (!$ioFile->fileExists($fileName)) {
                $ioFile->streamOpen($fileName);
                $ioFile->streamLock(true);
                foreach ($this->entries as $entry => $value) {
                    $ioFile->streamWrite(ucfirst($entry) . ": $value\n");
                }
                $ioFile->streamUnlock();
                $ioFile->streamClose();
            }

            return true;

        } catch (Exception $e) {
            Mage::logException($e);
            if ($path == '.well-known') {
                $this->generateOrUpdateFile('');
            } else {
                return false;
            }
        }
    }

    /**
     * Create Writeable directory if it doesn't exist
     *
     * @param string Absolute directory path
     * @return void
     * @throws Exception
     */
    protected function _createWriteableDir($path)
    {
        $io = new Varien_Io_File();
        if (!$io->isWriteable($path) && !$io->mkdir($path, 0777, true)) {
            Mage::throwException(Mage::helper('catalog')->__("Cannot create writeable directory '%s'.", $path));
        }
    }

    /**
     * Get config value
     * @param $identifier
     * @return string|null
     */
    private function getConfig($identifier): ?string
    {
        if ($identifier == 'contact') {
            $contact = Mage::getStoreConfig(self::XML_CONFIG_PATH_SUFFIX . $identifier);
            return empty($contact) ? Mage::getStoreConfig(self::XML_CONFIG_CONTACT_FALLBACK) : $contact;
        } else {
            return Mage::getStoreConfig(self::XML_CONFIG_PATH_SUFFIX . $identifier);
        }
    }

}